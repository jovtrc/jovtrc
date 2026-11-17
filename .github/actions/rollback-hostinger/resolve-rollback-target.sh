#!/usr/bin/env bash
# ─────────────────────────────────────────────────────────────────────────────
# RESOLVE O RELEASE-ALVO DE UM ROLLBACK (roda NO SERVIDOR, via `ssh ... bash -s`)
#
# Imprime SÓ o id do release-alvo no stdout (erros vão pro stderr). O rollback
# captura esse stdout e passa o id pro activate-release.sh (que re-aponta o
# `current` atomicamente — rollback = mesma ativação, num release que já existe).
#
# Entradas (env):
#   DEPLOY_WP_CONTENT        caminho absoluto do wp-content
#   DEPLOY_RELEASES_DIRNAME  nome do diretório de releases (_deployment_files)
#   DEPLOY_TARGET_RELEASE    (opcional) id explícito; vazio = release anterior ao ativo
#
# Sem process substitution — alguns shells de hospedagem não expõem /dev/fd nessa execução.
# ─────────────────────────────────────────────────────────────────────────────
set -euo pipefail

RELEASES="${DEPLOY_WP_CONTENT:?DEPLOY_WP_CONTENT obrigatório}/${DEPLOY_RELEASES_DIRNAME:?DEPLOY_RELEASES_DIRNAME obrigatório}"
cd "$RELEASES" 2>/dev/null || { echo "ERRO: diretório de releases inexistente: $RELEASES" >&2; exit 1; }

current_target="$(readlink current 2>/dev/null || true)"
want="${DEPLOY_TARGET_RELEASE:-}"

# Id explícito informado: valida e usa.
if [ -n "$want" ]; then
  [ -d "$want" ] || { echo "ERRO: release '$want' não existe em $RELEASES" >&2; exit 1; }
  echo "$want"
  exit 0
fi

# Sem id: pega o release mais novo que NÃO é o ativo (= o imediatamente anterior).
# Ordena por NOME desc (id = <YYYYMMDD-HHMMSS-sha>, lexicograficamente ordenável).
prev=""
for r in $(ls -1d */ 2>/dev/null | sed 's:/$::' | { grep -vx 'current' || true; } | sort -r); do
  if [ "$r" = "$current_target" ]; then
    continue
  fi
  prev="$r"
  break
done

[ -n "$prev" ] || { echo "ERRO: não há release anterior para rollback (ativo: ${current_target:-nenhum})" >&2; exit 1; }
echo "$prev"
