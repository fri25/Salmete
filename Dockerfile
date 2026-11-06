# syntax=docker/dockerfile:1
# =============================================================================
# SaLMeTE — image de production (Laravel 13 / PHP 8.4 / Apache)
# -----------------------------------------------------------------------------
# Build : docker compose build
# Run   : docker compose up -d
#
# L'image `prod` sert à la fois `app` (Apache + PHP), `queue` et `scheduler`
# (mêmes fichiers, commande Artisan différente). Les assets Vite sont cuits
# dans l'image : aucune dépendance Node au runtime.
#
# Réseau : Apache écoute sur le port 80 INTERNE, sans port publié sur l'hôte.
# L'exposition publique est faite par Traefik (réseau externe `proxy`) qui
# termine le TLS. Voir compose.yml.
# =============================================================================
ARG PHP_VERSION=8.4
ARG NODE_VERSION=22

# ---------- 1. Assets frontend (Vite 8 + Bootstrap 5 + Sass) ----------
FROM node:${NODE_VERSION}-bookworm-slim AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci --no-audit --no-fund
COPY vite.config.js ./
COPY resources ./resources
COPY public ./public
RUN npm run build

# ---------- 2. Dépendances PHP de production ----------
# --no-scripts : pas de `package:discover` ici (pas de .env, pas de DB au build).
# La découverte est rejouée dans l'image prod puis à l'entrée du conteneur.
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install \
        --no-dev \
        --no-interaction \
        --no-progress \
        --prefer-dist \
        --optimize-autoloader \
        --no-scripts \
        --ignore-platform-reqs

# ---------- 2 bis. Dépendances PHP avec outils de dev (PHPUnit) ----------
# Uniquement pour le service `tests` (profil Compose `test`), jamais déployé.
FROM composer:2 AS vendor-dev
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install \
        --no-interaction \
        --no-progress \
        --prefer-dist \
        --optimize-autoloader \
        --no-scripts \
        --ignore-platform-reqs

# ---------- 3. Runtime PHP + Apache ----------
FROM php:${PHP_VERSION}-apache-bookworm AS runtime

# Extensions applicatives : MySQL, intl, zip, gd (logos/upload galerie), bcmath.
# mbstring, curl, pdo_sqlite et OPcache sont déjà fournis par l'image de base.
RUN apt-get update && apt-get install -y --no-install-recommends \
        git unzip libicu-dev libzip-dev \
        libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" pdo_mysql intl zip gd bcmath \
    && a2enmod rewrite headers deflate expires \
    && rm -rf /var/lib/apt/lists/*

# Configuration PHP de production + durcissement Apache.
COPY docker/php/php.ini /usr/local/etc/php/conf.d/zz-salmete.ini
COPY docker/apache-security.conf /etc/apache2/conf-available/salmete-security.conf
RUN a2enconf salmete-security
COPY docker/apache-vhost.conf /etc/apache2/sites-available/000-default.conf

# Sonde de santé interne (GET /up) et point d'entrée commun app/queue/scheduler.
COPY docker/healthcheck.sh /usr/local/bin/salmete-healthcheck
COPY docker-entrypoint.sh /usr/local/bin/salmete-entrypoint
RUN chmod +x /usr/local/bin/salmete-healthcheck /usr/local/bin/salmete-entrypoint

# ---------- 3 bis. Code source commun (prod + tests en dérivent) ----------
FROM runtime AS app-src
WORKDIR /var/www/html
COPY . .

# Vendor de prod + assets buildés (écrasent le contenu éventuel du contexte).
COPY --from=vendor /app/vendor ./vendor
COPY --from=assets /app/public/build ./public/build

# Permissions Laravel : storage et bootstrap/cache inscriptibles par www-data
# (Apache tourne en www-data ; queue/scheduler sont lancés avec cet UID).
RUN mkdir -p \
        storage/app/public \
        storage/app/private \
        storage/framework/cache \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && php artisan package:discover --ansi

# ---------- 4. Image de production ----------
FROM app-src AS prod
# La suite de tests n'a rien à faire dans l'image déployée.
RUN rm -rf tests
EXPOSE 80
ENTRYPOINT ["/usr/local/bin/salmete-entrypoint"]
CMD ["apache2-foreground"]

# ---------- 5. Image de test (PHPUnit) — jamais déployée ----------
# Usage : docker compose --profile test run --rm tests
# Vendor complet (dont PHPUnit) et dossier tests/. L'entrypoint de prod est
# neutralisé : le conteneur de test ne migre pas la base de production.
FROM app-src AS tests
COPY --from=vendor-dev /app/vendor ./vendor
RUN touch .env \
    && chown -R www-data:www-data storage bootstrap/cache
ENTRYPOINT []
CMD ["php", "artisan", "test"]
