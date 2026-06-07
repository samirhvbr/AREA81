# Blog Samirhv — Roteiro de Construção

> Hoje temos o **layout** pronto (tema Canvas) e os posts num **array estático** no
> `BlogController`. Este roteiro leva o blog de "layout" a "blog de verdade" — conteúdo
> em banco, autoria, categorias/tags reais — e o prepara como **superfície de entrega do
> projeto de notícias**. O visual Canvas é preservado: a gente troca o motor por baixo,
> não a cara.

---

## Ponto de partida (o que já existe)

- **Controller** — `BlogController` com `allPosts()` (array, 1 post hoje), `categories()`
  e `topics()` (cards da home com ícone + descrição). Ações: `home()`, `index()`
  (filtra por `?categoria=`, pagina 9/página com `LengthAwarePaginator`) e `show()`
  (acha por slug, com `prevPost`/`nextPost` e `abort 404`).
- **Rotas** — `/` → `home`; `/blog` → `blog.index`; `/blog/{slug}` → `blog.show`
  (grupo nomeado `blog.`).
- **Views** — `home`, `blog/index`, `blog/show`, com os cards "glass", paginação e o
  filtro de categorias já desenhados (dark + indigo, Inter / JetBrains Mono).
- **Tags** — existem no array de cada post, mas **não filtram** nada ainda.

## Onde queremos chegar (o todo do projeto)

Um blog com posts no banco, autoria de verdade, categorias e tags navegáveis, **e** que
hospeda a página dos **resumos de notícias** (alimentada pelo `BlogPublisher`, com player
de áudio do Piper). Mesmo app Laravel, mesmo tema, conventions já estabelecidas.

## Princípios

- **Preservar o layout Canvas** — nada de redesenhar; só plugar dados reais.
- **Controllers finos + services** — a lógica do `allPosts()` migra pra um `PostService`.
- **Rotas nomeadas atuais mantidas** (`home`, `blog.index`, `blog.show`).
- **MySQL / MariaDB** — nunca SQLite.
- **Churn mínimo nas views** — model Eloquent implementa `ArrayAccess`, então `$post['slug']`
  continua funcionando; só `date` (vira `published_at` formatado) e `tags` (vira relação)
  pedem ajuste pontual.
- **version.md + commits no padrão** `versão - comentário`.

---

## Fase 0 — Modelo de dados

- [ ] Migration `posts`: `slug` (único), `title`, `excerpt`, `content` (longtext),
      `is_featured` (bool), `published_at` (datetime), `reading_time` (nullable),
      `category_id` (FK)
- [ ] Migration `categories`: `slug` (único), `name`, `icon`, `description`
      (absorve o `categories()` + `topics()` de hoje)
- [ ] Migration `tags`: `slug` (único), `name` + pivot `post_tag`
- [ ] Models `Post`, `Category`, `Tag` com relações (Post belongsTo Category;
      Post belongsToMany Tag)
- [ ] Seeder migrando o conteúdo atual (`allPosts`, `categories`, `topics`) pro banco

## Fase 1 — Trocar o motor (array → banco), layout intacto

- [ ] `PostService` com os métodos que o controller usa: post em destaque, recentes,
      listagem paginada (com filtro), busca por slug com `prev`/`next`
- [ ] `BlogController` fino chamando o service; manter `home()`, `index()`, `show()` e
      os nomes de rota
- [ ] Ajuste pontual nas views: `published_at` formatado (accessor ou no Blade), `tags`
      como relação; manter `$post['...']` onde der
- [ ] Conferir paginação (já existe) e o `?categoria=` apontando pro `category_id`

## Fase 2 — Categorias e tags de verdade

- [ ] Decisão editorial: reestruturar categorias (Tecnologia, Política, Reflexões, Geral;
      demover `dev`/`linux` pra tags)
- [ ] Filtro real por categoria **e por tag** (`?tag=`), com links clicáveis no tema
- [ ] Páginas de listagem por tag; contador de posts por categoria/tag

## Fase 3 — Autoria (como criar posts)

- [ ] Decisão: **painel admin autenticado** (CRUD de posts) **vs** posts em **Markdown**
      commitados + parser
      - admin (ex.: Filament ou um CRUD enxuto) = escrever pelo navegador, sem deploy
      - markdown em arquivos = simples, versionado no git, sem auth — bom pra dev solo
- [ ] Slug automático (`Str::slug`), validação, upload de imagem (`storage:link` já existe)
- [ ] Status rascunho/publicado (via `published_at` no futuro/nulo)

## Fase 4 — Conteúdo, SEO e feed

- [ ] `reading_time` automático (contagem de palavras do `content`)
- [ ] Meta tags + Open Graph nas views (o layout já tem `@section('title')` /
      `@section('description')`)
- [ ] `sitemap.xml` e **feed RSS do próprio blog** — fecha o ciclo: o blog vira uma fonte
      RSS, conectando direto com o projeto de notícias
- [ ] Canonical e timezone das datas

## Fase 5 — Integração com o News Digest (o "todo")

- [ ] Rota/página que o `BlogPublisher` alimenta: listagem dos digests diários
      (tabela `news_digests` do outro roteiro)
- [ ] Decisão: digest é um "tipo de post" **vs** seção própria — recomendo **seção própria**
      (`news.index` / `news.show`) pra não misturar com posts editoriais, reusando o mesmo
      tema e os mesmos cards
- [ ] Player de áudio (MP3 do Piper) embutido na página do digest
- [ ] Item de menu "Resumo de Notícias" na navegação

## Fase 6 — Qualidade e deploy

- [ ] Checklist de PR: `php -l`, `route:list`, `view:cache`/`view:clear`, README, version.md
- [ ] `version.md`: **Y+** por mudança estrutural (entrada do banco), **Z+** por tela/feature
- [ ] `mariadb:backup` antes de rodar migrations em produção
- [ ] Deploy Debian: `pull` → `composer install` → `migrate` → `npm build` →
      `storage:link` → `optimize:clear`

---

## Decisões a tomar

- **Migrar pra banco agora?** Recomendo **sim** — o projeto inteiro (e o news digest)
  depende disso; o array foi só o ponto de partida.
- **Autoria:** painel admin ou Markdown em arquivos?
- **Categorias:** confirmar a reestruturação (decisão editorial sua).
- **Digest:** "tipo de post" ou seção própria? (recomendo seção própria)

## Ordem de construção

Linear: sem **modelo de dados** não há motor; sem **motor** não há navegação nem autoria;
**SEO/feed** e a **integração com notícias** entram depois que o blog está de pé. Cada
fase deixa o blog funcionando — você nunca fica com o site quebrado no meio do caminho.
