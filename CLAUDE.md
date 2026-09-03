# Samirhv Blog — Guia para Agentes de IA

Este documento orienta agentes de IA (Claude Code, etc.) que trabalham no projeto **Samirhv Blog**.

---

## 🔄 Antes de começar: `git pull`

**SEMPRE** verifique atualizações remotas antes de escrever ou alterar qualquer coisa neste repositório:

```bash
git pull          # já está pré-autorizado (allow)
```

Trabalhar sobre uma base desatualizada gera conflitos. Puxe primeiro, sempre. Para só inspecionar antes: `git fetch && git status`.

---

## Comunicação

- **Idioma:** Português (pt-BR) para mensagens ao operador, comentários e textos de UI.
- **Commits:** Formato `versão - comentário` (ex: `0.1.0 - adiciona página de contato`). Versão extraída de `version.md`. **Mensagem em inglês (US)** (ADR-014 do repodocs).
- **Identificadores de código:** Inglês (classes, métodos, variáveis, rotas).
- **Strings de UI:** Português.

---

## Stack

- **Framework:** Laravel (PHP 8.4+), pasta `area81/`
- **Template engine:** Blade
- **Frontend:** Canvas 7 (tema HTML5) — assets em `public/vendor/canvas/`
- **Banco de Dados:** MySQL / MariaDB — nunca usar SQLite em nenhum contexto
- **CSS theme:** `public/vendor/canvas/style.css` + `css/blog-theme.css`

---

## Pastas Temporárias

`tmp/` na raiz é para referência visual apenas — não referenciar no código de produção. Se precisar de um asset de lá, copiar para `public/vendor/canvas/`.

---

## Convenções (Laravel)

- **Controllers finos:** request handling + response. Lógica vai em Services.
- **Nomes de views:** `snake_case` em sub-pastas (ex: `blog/show.blade.php`).
- **Rotas nomeadas:** sempre com `->name()`, ex: `route('blog.show', $slug)`.
- **Assets:** sempre via `asset('vendor/canvas/...')`, nunca caminho relativo.
- **Str::limit:** usar para truncar excerpts no blade.

## Adicionando Posts

Posts são definidos no array `allPosts()` do `BlogController`. Cada post tem:

```php
[
    'slug'         => 'meu-post',        // URL: /blog/meu-post
    'title'        => 'Título do post',
    'excerpt'      => 'Resumo curto...',
    'content'      => '<p>HTML do conteúdo</p>',
    'category'     => 'tecnologia',      // deve estar em categories()
    'tags'         => ['tag1', 'tag2'],
    'date'         => '30 mai. 2026',
    'reading_time' => 5,                 // minutos
    'featured'     => false,             // destaque na home
]
```

## Comandos Rápidos

| Comando                          | Uso                                   |
|----------------------------------|---------------------------------------|
| `php artisan serve`              | Servidor local (http://localhost:8000)|
| `php artisan route:list`         | Lista rotas registradas               |
| `php artisan view:clear`         | Limpa cache de views                  |
| `php artisan optimize:clear`     | Limpa todo cache                      |
| `php -l arquivo.php`             | Valida sintaxe PHP                    |

## Checklist de PR

- [ ] `php -l` em arquivos PHP alterados
- [ ] `php artisan route:list` sem erros
- [ ] `php artisan view:cache` valida Blade (depois `view:clear`)
- [ ] `README.md` atualizado se mudou estrutura
- [ ] `version.md` incrementado (Z+1 para mudança de layout/feature)

---

<!-- COMMIT-RULE:repodocs -->

## Commits — you commit, and nothing is delivered until you have

> Marked echo. The single source is **[samirhvbr/repodocs](https://github.com/samirhvbr/repodocs/blob/master/docs/versioning.md#who-commits-and-when)**
> — change it there, not here. This block is regenerated.

**Committing is your job.** Not "leave the tree ready and something downstream
packages it" — you run `git commit`, and `git push`, as the last step of the work
you were asked to do. The COMMITTER skill that used to commit on an agent's
behalf is `enabled: false` in every repository of this fleet since 03/09/2026;
what is left of it is a kill-switch, not a scheduler. **If you do not commit,
nobody does.**

**Do not report a task as finished before the commit exists.** "Done",
"delivered", "concluded" mean the work is in `git log` — never that it is sitting
uncommitted where only this session can see it. The commit is the last step *of
the task*, not a follow-up for someone else. If you are about to write
"finished", commit first, then write it.

**Push is part of the delivery, and a refused push is the one place a human enters.**
Commit *and* push, every delivery — a clean push needs nobody's permission and is never
held back for review. When the push is **refused** (conflict, non-fast-forward, protected
branch), stop there and say so: never force, never rewrite history to get past it, never
invent a merge resolution you have not verified. The gate is the refused push, not the
commit.

**Every commit obeys the versioning rules**, with no exception:

- Subject `X.Y.Z - short description in English (US)`, the version taken from
  `version.md` and **bumped in the same commit**.
- The `CHANGELOG.md` entry is written first — its `## X.Y.Z - description`
  heading *is* the subject.
- No Conventional Commits prefix (`feat:`, `fix:`, `chore:`) and no vague
  subject ("update", "ajuste", "wip", "changes", "several improvements").

**The bump is the one clause a repository may override — in writing.** If this
repository's own documentation says the version is stamped some other way, and says
why, follow that. Otherwise the line above applies to you. An override nobody wrote
down is not an exception. Nothing else in this block bends: the changelog entry, the
subject, the language, one subject per commit, and committing before you report done
all hold regardless.

**One subject per commit.** The subject has to describe the whole commit
honestly. The moment your description needs an "and" to be true, it is two
commits.

**Split a large delivery into blocks.** A complex task is committed as a series
of commits grouped by subject, each small enough to be described in one line and
read on its own. They may share a version — bump `version.md` in the first and
repeat the number in the rest; two commits carrying one version is expected, not
a mistake. **Splitting is the default** for anything non-trivial, because the
history is the documentation of *how* the work was done, and one commit touching
six unrelated subjects documents none of them.

**The standard you are keeping:** someone reading `git log` alone — a year from
now, without the conversation that produced the work — can say what happened,
when, why, and at which version. If your commit would fail that test, it is too
big or its subject is too vague, and both are fixed the same way.

<!-- /COMMIT-RULE -->

---

<!-- RELEASES-RULE:repodocs -->

## Releases — the `version.md` on GitHub is what the Releases show

> Marked echo. The single source is **[samirhvbr/repodocs](https://github.com/samirhvbr/repodocs/blob/master/docs/versioning.md)**
> — change it there, not here. This block is regenerated.

**The `version.md` of the default branch, on GitHub, is what the GitHub Releases
must show.** The local checkout does not enter the calculation: it can be behind,
ahead or mid-work, and none of that is published — GitHub cannot tag a commit it
does not have.

**The bump and the Release are one act.** A commit that bumps `version.md` is not
finished until that version has a tag, a published Release, and the **`Latest`
badge on it** — the same push, not "later". A badge sitting on an older release
tells whoever looks that the project is at a version it is not.

- `.github/workflows/release.yml` does it on any push that touches `version.md`.
- `./tools/release.sh` does it by hand. It is **idempotent and self-healing**:
  it publishes whatever is missing and moves a drifted badge back. Running it is
  always safe, so it is both the check and the fix.

A PR publishes nothing while it is a PR. The moment it merges, the push moves
`version.md` on the default branch and the Release becomes that version.

Tag and Release title are the **bare version — no `v` prefix**.

## Language — English (US), everywhere in the repository

**Everything that lives in this repository, or in GitHub's interface around it,
is written in English (US)**: documents, **commit messages**, pull request titles
and bodies, issues, code comments, changelog entries, release notes.

Commit format: `X.Y.Z - short description in English`. The version comes from
`version.md` and is bumped in the same commit. Conventional Commits prefixes
(`feat:`, `fix:`, `chore:`) and vague one-word messages are forbidden.

**Exactly one carve-out:** end-user-facing strings — UI text, transactional
email, product copy. That is product i18n for a Brazilian audience, not
repository content.

History is not rewritten: Portuguese messages already in the log stay as they
are.

<!-- /RELEASES-RULE -->
