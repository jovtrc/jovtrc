# carvalho.cc

Site pessoal de João Carvalho. O conteúdo da branch `carvalho-cc` é o `wp-content` do site.
O `README.md` da raiz é o do perfil no GitHub e vem da `master`.
O core do WordPress e os `uploads/` são geridos pela hospedagem (Hostinger).
Os plugins são declarados no `composer.json` e instalados com `composer install`.

| Caminho | Papel |
|---|---|
| `themes/carvalho/` | Tema de blocos do site (theme.json v3, templates, parts e patterns). |
| `plugins/` | Plugins de terceiros, instalados via Composer (ignorado no git; regenerado no deploy). |
| `composer.json` · `composer.lock` | Plugins e suas versões. Para adicionar: `composer require wp-plugin/<slug>`. |
| `design/` | Mockups das direções visuais. Não vai para o servidor. |
| `content/posts/` | Rascunhos dos posts em marcação de blocos. O nome do arquivo é o slug. Não vai para o servidor. |
| `content/setup.php` | Configuração inicial do site: tema, páginas, posts e links permanentes. |
| `.github/` | Deploy, rollback e setup na Hostinger. |

## Deploy (Hostinger via SSH)

`push` na branch `carvalho-cc` (ou execução manual) dispara `.github/workflows/deploy.yml`:
`composer install --no-dev` → envio como novo release em
`~/domains/carvalho.cc/public_html/wp-content/_deployment_files/<id>/` → troca atômica do
symlink `current` → limpeza do LiteSpeed Cache. Rollback manual em `.github/workflows/rollback.yml`.

Configure no repositório (Settings → Environments → `production`):

| Tipo | Nome | Descrição |
|---|---|---|
| Secret | `SSH_HOST` | host SSH da Hostinger |
| Secret | `SSH_USER` | usuário SSH |
| Secret | `SSH_PASSWORD` | senha SSH (auth via `sshpass`) |
| Secret | `SSH_PORT` | porta SSH (opcional, default `65002` na Hostinger) |
| Variable | `SITE_URL` | URL pública para o health check (opcional) |

Diretórios enviados no deploy: `themes/` e `plugins/` (symlink por item, deixando
intactos o tema padrão e os plugins instalados pelo wp-admin). O que não vai para
o servidor está no `.deployignore`.

Execução manual, pela linha de comando (a branch do site não é a padrão do
repositório, então o botão "Run workflow" não aparece no GitHub):

```bash
gh workflow run deploy.yml --ref carvalho-cc
gh workflow run rollback.yml --ref carvalho-cc
gh workflow run setup.yml --ref carvalho-cc
```

## Setup

`.github/workflows/setup.yml` (execução manual) envia `content/` para o servidor e
roda `content/setup.php` com o WP-CLI. Também fixa `LSWCP_TAG_PREFIX` no `wp-config.php`
(sem isso, a limpeza do LiteSpeed não alcança o cache de releases anteriores) e esvazia o
cache. Rode depois do primeiro deploy. Pode rodar
de novo: o que já existe não é recriado. O site local usa o mesmo arquivo.
