#!/usr/bin/env bash
# ─────────────────────────────────────────────────────────────────────────────
# WP-CLI COM PHP 8.3+ (roda NO SERVIDOR, via `ssh ... bash -s -- <argumentos do wp>`)
#
# O `php` da linha de comando da Hostinger pode ser mais antigo que o do site,
# e o tema exige PHP 8.3. Este script procura um PHP 8.3 ou mais novo e roda o
# WP-CLI com ele.
#
# Entradas (env):
#   DEPLOY_WP_ROOT  caminho absoluto da instalação do WordPress
# ─────────────────────────────────────────────────────────────────────────────
set -euo pipefail

cd "${DEPLOY_WP_ROOT:?DEPLOY_WP_ROOT obrigatório}"

php_ok() {
  "$1" -r 'exit(version_compare(PHP_VERSION, "8.3", ">=") ? 0 : 1);' >/dev/null 2>&1
}

PHP=""
for candidate in php php8.5 php8.4 php8.3 php85 php84 php83 \
  /opt/alt/php85/usr/bin/php /opt/alt/php84/usr/bin/php /opt/alt/php83/usr/bin/php; do
  if command -v "$candidate" >/dev/null 2>&1 && php_ok "$candidate"; then
    PHP="$(command -v "$candidate")"
    break
  fi
done

if [ -z "$PHP" ]; then
  echo "ERRO: nenhum PHP 8.3+ encontrado. php -v: $(php -v 2>&1 | head -1)" >&2
  ls -1d /opt/alt/php*/usr/bin/php /usr/bin/php* /usr/local/bin/php* >&2 2>/dev/null || true
  exit 1
fi

WP="$(command -v wp)"
echo "▶ WP-CLI com $PHP ($("$PHP" -r 'echo PHP_VERSION;'))" >&2

if head -c 100 "$WP" | grep -q 'php'; then
  exec "$PHP" "$WP" "$@" </dev/null
fi
WP_CLI_PHP="$PHP" exec "$WP" "$@" </dev/null
