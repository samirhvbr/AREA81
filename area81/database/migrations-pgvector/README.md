# Migrations PostgreSQL + pgvector (subsistema de notícias)

Estas migrations **NÃO** rodam no deploy padrão (`php artisan migrate` / `deploy.sh`),
que é MariaDB. Elas ficam aqui de propósito, fora de `database/migrations/`, para
**não travar o deploy do blog** — usam a conexão `pgsql_vector` (PostgreSQL com a
extensão [pgvector](https://github.com/pgvector/pgvector)), que é um subsistema à
parte (agregação de notícias com embeddings).

## Pré-requisitos

1. **Driver PHP**: `pdo_pgsql` instalado e habilitado na CLI
   (ex.: `apt install php8.4-pgsql && systemctl reload php8.4-fpm`).
2. **Servidor PostgreSQL** com a extensão `vector` disponível
   (`CREATE EXTENSION vector;` — a própria migration cria se faltar).
3. **Variáveis no `.env`** (a conexão `pgsql_vector` em `config/database.php` as lê):
   ```
   PG_HOST=127.0.0.1
   PG_PORT=5432
   PG_DATABASE=area81
   PG_USERNAME=shv81
   PG_PASSWORD=...
   PG_SSLMODE=prefer
   ```

## Rodar / reverter

```bash
# aplica (quando os pré-requisitos acima estiverem prontos)
php artisan migrate --path=database/migrations-pgvector --database=pgsql_vector

# reverte
php artisan migrate:rollback --path=database/migrations-pgvector --database=pgsql_vector
```

> Sem `--path`, o Laravel só varre `database/migrations/` (não-recursivo), então
> estas migrations ficam invisíveis para o `migrate` normal — exatamente o que
> queremos até o Postgres estar no ar.
