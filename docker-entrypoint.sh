#!/usr/bin/env sh
# =============================================================================
# SaLMeTE — point d'entrée commun aux services `app`, `queue` et `scheduler`.
# -----------------------------------------------------------------------------
# - `app`       : attend MySQL, lie le storage, migre, met en cache la config,
#                 les routes et les vues, puis lance Apache sur le port PORT.
# - `queue`/`scheduler` : exécutent uniquement `package:discover` puis la
#                 commande Artisan (pas de migration ni de cache : cela
#                 éviterait les courses avec `app`).
#
# Les workers tournent avec l'UID www-data (33) : le `sed` sur /etc/apache2
# n'est donc exécuté que par `app` (lancé en root).
# =============================================================================
set -eu

# 1. Détection du rôle (workers) AVANT toute action sur /etc.
is_worker=0
case "$*" in
    *queue:work*|*schedule:work*|*schedule:run*)
        is_worker=1
        ;;
esac

if [ "$is_worker" -eq 1 ]; then
    echo "[entrypoint] worker ($*) : aucune migration/cache ici."
    cd /var/www/html
    php artisan package:discover --ansi || true
    exec "$@"
fi

# 2. Port d'écoute Apache. 80 par défaut derrière Traefik ; PORT=10000 reste
#    possible pour un hébergement qui impose un port applicatif.
PORT="${PORT:-80}"
sed -i "s/^Listen 80$/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

cd /var/www/html

# 3. Garde-fou : sans APP_KEY, Laravel démarre mais casse au premier chiffrement.
if [ -z "${APP_KEY:-}" ]; then
    echo "[entrypoint] ERREUR : APP_KEY est vide. Générez-la (php artisan key:generate --show) et renseignez .env." >&2
    exit 1
fi

# 4. Attente de MySQL (max ~60 s). Le healthcheck de mysql reste la référence ;
#    ce délai évite un crash-loop au premier démarrage du volume.
echo "[entrypoint] attente de la base (${DB_HOST:-mysql}:${DB_PORT:-3306})..."
tentatives=0
until php artisan db:show --no-interaction >/dev/null 2>&1; do
    tentatives=$((tentatives + 1))
    if [ "$tentatives" -ge 30 ]; then
        echo "[entrypoint] base injoignable après 60 s — démarrage quand même (voir logs)." >&2
        break
    fi
    sleep 2
done

# 5. Lien public/storage (images de la galerie, logos partenaires).
php artisan storage:link --force --no-interaction || true

# 6. Découverte des packages (compense le --no-scripts du build Composer).
php artisan package:discover --ansi || true

# 7. Migrations idempotentes. Jamais de seed automatique en production.
php artisan migrate --force --no-interaction

# 8. Caches de production (régénérés à chaque démarrage pour refléter l'env
#    réellement injecté par Compose).
php artisan config:cache --no-interaction
php artisan route:cache --no-interaction
php artisan view:cache --no-interaction

echo "[entrypoint] prêt — Apache sur le port ${PORT}."
exec "$@"
