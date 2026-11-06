#!/bin/sh
# =============================================================================
# SaLMeTE — sonde de santé interne du conteneur `app`.
# -----------------------------------------------------------------------------
# Interroge la route Laravel /up (déclarée dans bootstrap/app.php) DANS le
# conteneur. Avec route:cache, la réponse est du HTML (la closure sérialisée
# ne peut pas être mise en cache). On se contente de vérifier que le code HTTP
# est 2xx (`curl -f`) : si Apache + PHP répondent, l'application est en vie.
#
# La base n'est pas testée ici : c'est le rôle du healthcheck du service mysql
# et de l'attente de l'entrypoint avant les migrations.
# =============================================================================
set -eu

URL="http://127.0.0.1:${PORT:-80}/up"

if ! curl -fsS --max-time 5 "$URL" >/dev/null 2>&1; then
    echo "healthcheck: $URL injoignable" >&2
    exit 1
fi