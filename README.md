# AREA81 — Blog

Personal blog by Samir HV, built with Laravel and the Canvas 7 theme.

---

> Internal documentation — do not publish. (Does not go to production: see the deploy `--exclude` list below).
> Do not publish, but ideally version it.
> Always write commits with a good description; the push is optional, but the organized, documented commit is mandatory.

**See also:** [CLAUDE.md](CLAUDE.md) (code conventions and agent guide) · [SECURITY_GUIDELINES.md](SECURITY_GUIDELINES.md) (security — review whenever the stack changes or a new user input is added)

## Version (`version.md`)

The project version lives in `version.md` at the root. Format `X.Y.Z`:

- **X** — final stable version (manual change)
- **Y** — significant structural change (0–99)
- **Z** — increment for a new screen, new table, layout change or feature → `Z+1` (0–999)

---

## Stack

| Layer         | Technology                          |
|---------------|-------------------------------------|
| Backend       | PHP 8.4+ / Laravel                  |
| Templates     | Blade                               |
| Frontend      | Canvas 7 (HTML5 theme)              |
| Database      | MySQL / MariaDB                     |
| Build         | Vite + npm                          |

The Laravel application lives in `samirhv/`. Theme assets in `public/vendor/canvas/`.

---

## Project Structure

```
AREA81/
├── samirhv/                  # Laravel application
│   ├── app/Http/Controllers/ # BlogController (posts, routes)
│   ├── resources/views/      # Blade views (blog/, layouts/)
│   ├── routes/web.php        # Named routes
│   └── public/vendor/canvas/ # Canvas 7 theme assets
├── docs/                     # Documentation and visual references
├── tmp/                      # Local visual reference (not versioned)
├── CLAUDE.md                 # Guide for AI agents
├── SECURITY_GUIDELINES.md    # Security guidelines
└── version.md                # Current version (MAJOR.MINOR.PATCH format)
```

---

## Local Setup

```bash
# 1. Enter the Laravel folder
cd samirhv

# 2. Install PHP dependencies
composer install

# 3. Install JS dependencies
npm install

# 4. Configure the environment
cp .env.example .env
php artisan key:generate

# 5. Configure the database (MySQL/MariaDB) in .env and run migrations
php artisan migrate

# 6. Start the server
php artisan serve          # http://localhost:8000
npm run dev                # Vite HMR (optional, dev)
```

---

## Useful Commands

| Command                         | Use                                    |
|---------------------------------|----------------------------------------|
| `php artisan serve`             | Local server (http://localhost:8000)   |
| `php artisan route:list`        | List registered routes                 |
| `php artisan optimize:clear`    | Clear all cache (views, config, routes)|
| `php artisan view:clear`        | Clear Blade view cache                 |
| `php -l <arquivo.php>`          | Validate PHP syntax                    |
| `composer audit`                | Check for vulnerabilities              |

---

## Adding Posts

Posts are defined in the `allPosts()` array of `BlogController`. Each entry:

```php
[
    'slug'         => 'meu-post',
    'title'        => 'Título do post',
    'excerpt'      => 'Resumo curto exibido na listagem.',
    'content'      => '<p>HTML do conteúdo completo</p>',
    'category'     => 'tecnologia',   // must exist in categories()
    'tags'         => ['php', 'web'],
    'date'         => '06 jun. 2026',
    'reading_time' => 5,              // estimated minutes
    'featured'     => false,          // featured on home
]
```

---

## Deploy

```bash
# On the server, after pull
composer install --no-dev --optimize-autoloader
npm run build
php artisan optimize
php artisan migrate --force

# Permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

See [SECURITY_GUIDELINES.md](SECURITY_GUIDELINES.md) for the full production checklist.

---

## Versioning

The `version.md` file contains the current version (`MAJOR.MINOR.PATCH`).  
Commits follow the format: `0.1.0 - change description`.

Increment **Z** for layout adjustments and new features within the current cycle.
