#!/usr/bin/env bash
# ---------------------------------------------------------------------------
# Installation / mise à jour du site sur alwaysdata.
# À lancer en SSH depuis le dossier du projet :  bash deploy-alwaysdata.sh
# Le premier lancement crée la clé d'application et remplit la base.
# ---------------------------------------------------------------------------
set -euo pipefail

cd "$(dirname "$0")"

if [ ! -f .env ]; then
    echo "Fichier .env absent : copiez .env.production.example en .env et complétez-le." >&2
    exit 1
fi

echo "→ Dépendances PHP (sans outils de développement)"
composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

if ! grep -qE '^APP_KEY=.+' .env; then
    echo "→ Génération de la clé d'application"
    php artisan key:generate --force
fi

echo "→ Dossiers de stockage"
mkdir -p storage/framework/{cache/data,sessions,views} storage/logs storage/app/public bootstrap/cache

echo "→ Base de données"
php artisan migrate --force

if [ "${1:-}" = "--seed" ]; then
    echo "→ Contenu initial (paramètres, programme, partenaires, sponsoring)"
    php artisan db:seed --force
fi

echo "→ Lien public/storage"
php artisan storage:link --force

echo "→ Mise en cache de la configuration, des routes et des vues"
php artisan optimize

echo "✓ Déploiement terminé."
