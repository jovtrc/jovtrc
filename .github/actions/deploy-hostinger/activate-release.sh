#!/usr/bin/env bash
# ─────────────────────────────────────────────────────────────────────────────
# ATIVAÇÃO DE RELEASE (roda NO SERVIDOR Hostinger, via `ssh ... bash -s`)
#
# Um release já foi enviado pelo deploy pra:
#   $WP_CONTENT/$RELEASES_DIRNAME/<RELEASE_ID>/
#
# Este script copia cada ITEM do release (cada tema, cada plugin) para
# wp-content/<dir>/<item> com rsync e aponta o symlink `current` para o release
# ativo. Os itens que não são nossos (tema padrão, plugins do wp-admin) ficam
# intactos.
#
# Por que cópia e não symlink: com wp-content/plugins/<item> apontando para
# _deployment_files/<id>/, o caminho real do código muda a cada release. Os
# plugins do Composer mantêm as datas de arquivo do pacote, então o opcache não
# recompila e o __FILE__ continua apontando para um release antigo. O WordPress
# deixa de reconhecer a pasta do plugin, gera URLs de CSS/JS quebradas e, quando
# o release antigo é podado, os includes falham. Com cópia, o caminho é fixo.
#
# A cópia não é atômica, mas leva segundos e só transfere o que mudou.
# `current` continua sendo a referência do release ativo (rollback e --link-dest).
#
# Entradas (variáveis de ambiente, setadas pelo workflow):
#   DEPLOY_WP_CONTENT        caminho absoluto do wp-content (ex.: /home/USER/domains/carvalho.cc/public_html/wp-content)
#   DEPLOY_RELEASES_DIRNAME  nome do diretório de releases (ex.: _deployment_files)
#   DEPLOY_RELEASE_ID        id do release a ativar (= nome do diretório enviado)
#   DEPLOY_PER_ITEM_DIRS     lista (espaço) de dirs copiados item a item (ex.: "themes plugins")
#   DEPLOY_KEEP              quantos releases manter na poda (default 5)
# ─────────────────────────────────────────────────────────────────────────────
set -euo pipefail

WP_CONTENT="${DEPLOY_WP_CONTENT:?DEPLOY_WP_CONTENT obrigatório}"
RDIRNAME="${DEPLOY_RELEASES_DIRNAME:?DEPLOY_RELEASES_DIRNAME obrigatório}"
RELEASE_ID="${DEPLOY_RELEASE_ID:?DEPLOY_RELEASE_ID obrigatório}"
PER_ITEM_DIRS="${DEPLOY_PER_ITEM_DIRS:-}"
KEEP="${DEPLOY_KEEP:-5}"

RELEASES="$WP_CONTENT/$RDIRNAME"
RELEASE="$RELEASES/$RELEASE_ID"
PREVIOUS="$(readlink "$RELEASES/current" 2>/dev/null || true)"

echo "▶ Ativando release: $RELEASE_ID (anterior: ${PREVIOUS:-nenhum})"
[ -d "$RELEASE" ] || { echo "❌ Release não encontrado no servidor: $RELEASE"; exit 1; }

# ── 1) Copia cada item do release para wp-content/<dir>/<item> ───────────────
for d in $PER_ITEM_DIRS; do
  parent="$WP_CONTENT/$d"
  src="$RELEASE/$d"
  [ -d "$src" ] || continue
  mkdir -p "$parent"

  for item_path in "$src"/*; do
    [ -e "$item_path" ] || continue            # glob sem match → literal
    item="$(basename "$item_path")"
    target="$parent/$item"

    # CUTOVER do layout antigo (symlink por item): copia para uma pasta
    # temporária, muda a data dos .php para o opcache recompilar com o caminho
    # fixo e só então troca o symlink pela cópia.
    if [ -L "$target" ]; then
      staging="$parent/.$item.cutover"
      rm -rf "$staging"
      rsync -a "$item_path/" "$staging/"
      find "$staging" -type f -name '*.php' -exec touch {} +
      rm -f "$target"
      mv "$staging" "$target"
      echo "⚠ CUTOVER: $d/$item (symlink → cópia)"
      continue
    fi

    if [ -d "$item_path" ]; then
      rsync -a --delete "$item_path/" "$target/"
    else
      rsync -a "$item_path" "$target"
    fi
  done

  # Remove itens que estavam no release anterior e saíram deste.
  if [ -n "$PREVIOUS" ] && [ "$PREVIOUS" != "$RELEASE_ID" ] && [ -d "$RELEASES/$PREVIOUS/$d" ]; then
    for old_path in "$RELEASES/$PREVIOUS/$d"/*; do
      [ -e "$old_path" ] || continue
      item="$(basename "$old_path")"
      if [ ! -e "$src/$item" ]; then
        rm -rf "${parent:?}/$item"
        echo "🧹 Removido: $d/$item"
      fi
    done
  fi
done
echo "✅ Itens copiados"

# ── 2) Aponta `current` para o release ativo (rename atômico) ────────────────
tmp="$RELEASES/.current.tmp.$$"
ln -s "$RELEASE_ID" "$tmp"
mv -Tf "$tmp" "$RELEASES/current"
echo "✅ current → $RELEASE_ID"

# ── 3) Limpa o object cache (best-effort; o release já está no ar) ────────────
WP_ROOT="$(dirname "$WP_CONTENT")"
if command -v wp >/dev/null 2>&1; then
  if ( cd "$WP_ROOT" && wp cache flush >/dev/null 2>&1 ); then
    echo "✅ wp cache flush"
  else
    echo "⚠ wp cache flush falhou (ignorado)"
  fi
fi

# ── 4) Poda releases antigos (best-effort — o release já está ATIVO) ──────────
# Mantém os $KEEP mais novos; nunca remove o ativo (alvo do `current`). Ordena
# pelo NOME do release (id = <YYYYMMDD-HHMMSS-sha>, lexicograficamente ordenável)
# em vez de por mtime — determinístico e imune a mtime resetado.
#
# Sem process substitution (`< <(...)`): alguns shells de hospedagem não expõem
# /dev/fd nessa execução (`bash -s` via ssh), então usamos um pipe simples pro
# `while read`. Toda falha aqui é ignorada — o deploy já está no ar.
current_target="$(readlink "$RELEASES/current" || true)"
prune_old() {
  ( cd "$RELEASES" || exit 0
    ls -1d */ 2>/dev/null | sed 's:/$::' | { grep -vx 'current' || true; } | sort -r | {
      idx=0
      while IFS= read -r r; do
        idx=$((idx + 1))
        [ "$idx" -le "$KEEP" ] && continue
        [ "$r" = "$current_target" ] && continue
        rm -rf -- "$r" && echo "🧹 Podado release antigo: $r"
      done
    }
  )
}
prune_old || echo "⚠ Poda falhou (ignorado — release já está ativo)"

echo "✅ Release $RELEASE_ID ativo."
