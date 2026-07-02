# AREA81 — Blog

Blog pessoal de Samir HV, construído com Laravel e tema Canvas 7.

---

> Documentação interna — não publicar. (Não vai para produção: ver lista de `--exclude` do deploy abaixo).
> Não publicar mas ideal versionar.
> Sempre faça os commits com uma boa descrição, o push é opcional, mas o commit organizado e documentado é obrigatório.

**Ver também:** [CLAUDE.md](CLAUDE.md) (convenções de código e guia para agentes) · [SECURITY_GUIDELINES.md](SECURITY_GUIDELINES.md) (segurança — revisar sempre que houver mudança de stack ou novo input de usuário)

## Versão (`version.md`)

A versão do projeto fica em `version.md` na raiz. Formato `X.Y.Z`:

- **X** — versão estável final (alteração manual)
- **Y** — mudança estrutural significativa (0–99)
- **Z** — incremento por nova tela, nova tabela, mudança de layout ou feature → `Z+1` (0–999)

---

## Stack

| Camada        | Tecnologia                          |
|---------------|-------------------------------------|
| Backend       | PHP 8.4+ / Laravel                  |
| Templates     | Blade                               |
| Frontend      | Canvas 7 (HTML5 theme)              |
| Banco de dados| MySQL / MariaDB                     |
| Build         | Vite + npm                          |

A aplicação Laravel fica em `samirhv/`. Assets do tema em `public/vendor/canvas/`.

---

## Estrutura do Projeto

```
AREA81/
├── samirhv/                  # Aplicação Laravel
│   ├── app/Http/Controllers/ # BlogController (posts, rotas)
│   ├── resources/views/      # Blade views (blog/, layouts/)
│   ├── routes/web.php        # Rotas nomeadas
│   └── public/vendor/canvas/ # Assets do tema Canvas 7
├── docs/                     # Documentação e referências visuais
├── tmp/                      # Referência visual local (não versiona)
├── CLAUDE.md                 # Guia para agentes de IA
├── SECURITY_GUIDELINES.md    # Diretrizes de segurança
└── version.md                # Versão atual (formato MAJOR.MINOR.PATCH)
```

---

## Setup Local

```bash
# 1. Entrar na pasta do Laravel
cd samirhv

# 2. Instalar dependências PHP
composer install

# 3. Instalar dependências JS
npm install

# 4. Configurar ambiente
cp .env.example .env
php artisan key:generate

# 5. Configurar banco (MySQL/MariaDB) no .env e rodar migrations
php artisan migrate

# 6. Subir servidor
php artisan serve          # http://localhost:8000
npm run dev                # Vite HMR (opcional, dev)
```

---

## Comandos Úteis

| Comando                         | Uso                                    |
|---------------------------------|----------------------------------------|
| `php artisan serve`             | Servidor local (http://localhost:8000) |
| `php artisan route:list`        | Lista rotas registradas                |
| `php artisan optimize:clear`    | Limpa todo cache (views, config, rota) |
| `php artisan view:clear`        | Limpa cache de views Blade             |
| `php -l <arquivo.php>`          | Valida sintaxe PHP                     |
| `composer audit`                | Verifica vulnerabilidades              |

---

## Adicionando Posts

Posts são definidos no array `allPosts()` de `BlogController`. Cada entrada:

```php
[
    'slug'         => 'meu-post',
    'title'        => 'Título do post',
    'excerpt'      => 'Resumo curto exibido na listagem.',
    'content'      => '<p>HTML do conteúdo completo</p>',
    'category'     => 'tecnologia',   // deve existir em categories()
    'tags'         => ['php', 'web'],
    'date'         => '06 jun. 2026',
    'reading_time' => 5,              // minutos estimados
    'featured'     => false,          // destaque na home
]
```

---

## Deploy

```bash
# No servidor, após pull
composer install --no-dev --optimize-autoloader
npm run build
php artisan optimize
php artisan migrate --force

# Permissões
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

Ver [SECURITY_GUIDELINES.md](SECURITY_GUIDELINES.md) para checklist completo de produção.

---

## Versionamento

O arquivo `version.md` contém a versão atual (`MAJOR.MINOR.PATCH`).  
Commits seguem o formato: `0.1.0 - descrição da mudança`.

Incrementar **Z** para ajustes de layout e features novas dentro do ciclo atual.
