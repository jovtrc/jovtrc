#!/usr/bin/env bash
# ─────────────────────────────────────────────────────────────────────────────
# ATIVAÇÃO DE RELEASE (roda NO SERVIDOR Hostinger, via `ssh ... bash -s`)
#
# Um release já foi enviado pelo deploy pra:
#   $WP_CONTENT/$RELEASES_DIRNAME/<RELEASE_ID>/   (diretório imutável, isolado)
#
# Este script o torna "ativo" trocando UM symlink (`current`) de forma ATÔMICA.
# `current` → o release ativo; tudo que é servido resolve ATRAVÉS dele, então
# mover `current` (rename(2), 1 syscall) troca o site de uma vez.
#
# Há DOIS tipos de diretório, porque alguns parents (themes, plugins) já contêm
# itens que NÃO gerenciamos aqui — o tema padrão do WP e plugins instalados pelo
# wp-admin (ex.: o LiteSpeed Cache da Hostinger). Symlinkar o diretório inteiro
# os esconderia, então:
#
#   • WHOLE  (diretórios 100% nossos, ex.: languages): symlinkamos o diretório
#     INTEIRO → _deployment_files/current/<dir>.
#
#   • PER_ITEM (parent com itens de terceiros — themes, plugins):
#     NÃO tocamos no parent. Pra cada ITEM que enviamos (cada tema/plugin),
#     criamos um symlink wp-content/<dir>/<item> → ../_deployment_files/current/<dir>/<item>.
#     Os itens que não são nossos (tema padrão, plugins do wp-admin) ficam intactos.
#
# Os dois tipos resolvem através de `current`, então o pivot do passo 1 troca
# tudo atomicamente. Em regime os laços abaixo são no-op (já são symlinks); só
# fazem trabalho na 1ª execução (cutover) ou quando um item é adicionado/removido.
#
# Entradas (variáveis de ambiente, setadas pelo workflow):
#   DEPLOY_WP_CONTENT        caminho absoluto do wp-content (ex.: /home/USER/domains/carvalho.cc/public_html/wp-content)
#   DEPLOY_RELEASES_DIRNAME  nome do diretório de releases (ex.: _deployment_files)
#   DEPLOY_RELEASE_ID        id do release a ativar (= nome do diretório enviado)
#   DEPLOY_PER_ITEM_DIRS     lista (espaço) de dirs com symlink POR ITEM
#   DEPLOY_WHOLE_DIRS        lista (espaço) de dirs com symlink do diretório inteiro
#   DEPLOY_KEEP              quantos releases manter na poda (default 5)
# ─────────────────────────────────────────────────────────────────────────────
set -euo pipefail

WP_CONTENT="${DEPLOY_WP_CONTENT:?DEPLOY_WP_CONTENT obrigatório}"
RDIRNAME="${DEPLOY_RELEASES_DIRNAME:?DEPLOY_RELEASES_DIRNAME obrigatório}"
RELEASE_ID="${DEPLOY_RELEASE_ID:?DEPLOY_RELEASE_ID obrigatório}"
PER_ITEM_DIRS="${DEPLOY_PER_ITEM_DIRS:-}"
WHOLE_DIRS="${DEPLOY_WHOLE_DIRS:-}"
KEEP="${DEPLOY_KEEP:-5}"

RELEASES="$WP_CONTENT/$RDIRNAME"
RELEASE="$RELEASES/$RELEASE_ID"
TS="$(date -u +%Y%m%d%H%M%S)"

echo "▶ Ativando release: $RELEASE_ID"
[ -d "$RELEASE" ] || { echo "❌ Release não encontrado no servidor: $RELEASE"; exit 1; }

# ── 1) Pivot atômico do `current` ────────────────────────────────────────────
# `ln -sfn` NÃO é atômico (unlink+symlink). O idioma atômico é criar um symlink
# temporário e renomeá-lo por cima com `mv -T` (= rename(2), 1 syscall).
tmp="$RELEASES/.current.tmp.$$"
ln -s "$RELEASE_ID" "$tmp"
mv -Tf "$tmp" "$RELEASES/current"
echo "✅ current → $RELEASE_ID (tudo que resolve via current troca atomicamente)"

# ── 2) WHOLE_DIRS — symlink do diretório inteiro ─────────────────────────────
for d in $WHOLE_DIRS; do
  link="$WP_CONTENT/$d"
  if [ -L "$link" ]; then
    continue
  fi
  if [ -e "$link" ]; then
    mv "$link" "$link.pre-symlink.$TS"
    echo "⚠ CUTOVER: '$d' (diretório real) → $d.pre-symlink.$TS"
  fi
  ln -s "$RDIRNAME/current/$d" "$link"
  echo "🔗 $d → $RDIRNAME/current/$d"
done

# ── 3) PER_ITEM_DIRS — parent com itens de terceiros: symlink só dos ITENS nossos ─
for d in $PER_ITEM_DIRS; do
  parent="$WP_CONTENT/$d"
  src="$RELEASE/$d"
  [ -d "$src" ] || continue
  mkdir -p "$parent"

  # 3a) Cria/garante o symlink de cada item do release (tema, plugin, arquivo).
  #     Alvo RELATIVO: de wp-content/<dir>/, sobe 1 nível (../) e entra em
  #     _deployment_files/current/<dir>/<item>.
  for item_path in "$src"/*; do
    [ -e "$item_path" ] || continue            # glob sem match → literal
    item="$(basename "$item_path")"
    link="$parent/$item"
    if [ -L "$link" ]; then
      continue
    fi
    if [ -e "$link" ]; then
      mv "$link" "$link.pre-symlink.$TS"
      echo "⚠ CUTOVER: '$d/$item' (real) → $item.pre-symlink.$TS"
    fi
    ln -s "../$RDIRNAME/current/$d/$item" "$link"
    echo "🔗 $d/$item → ../$RDIRNAME/current/$d/$item"
  done

  # 3b) Remove symlinks órfãos — item que existia em releases anteriores mas
  #     saiu deste. Só mexe em symlinks que apontam pro NOSSO _deployment_files
  #     (plugins/temas de terceiros apontam pra fora e não casam o padrão → intactos).
  for link in "$parent"/*; do
    [ -L "$link" ] || continue
    case "$(readlink "$link")" in
      *"$RDIRNAME/current/$d/"*)
        if [ ! -e "$link" ]; then              # symlink quebrado (alvo sumiu)
          rm -f "$link"
          echo "🧹 Symlink órfão removido: $d/$(basename "$link")"
        fi
        ;;
    esac
  done
done

# ── 4) Limpa o object cache (best-effort; o release já está no ar) ────────────
WP_ROOT="$(dirname "$WP_CONTENT")"
if command -v wp >/dev/null 2>&1; then
  if ( cd "$WP_ROOT" && wp cache flush >/dev/null 2>&1 ); then
    echo "✅ wp cache flush"
  else
    echo "⚠ wp cache flush falhou (ignorado)"
  fi
fi

# ── 5) Poda releases antigos (best-effort — o release já está ATIVO) ──────────
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
