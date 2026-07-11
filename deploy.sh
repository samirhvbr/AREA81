#!/bin/bash
# versão 1.0 - 2024-06-01

set -e  # para imediatamente se qualquer comando falhar

DIR="/srv/www/area81.com.br"
APP="$DIR/"

echo "==> Iniciando deploy..."

cd "$DIR"
git pull origin master

cd "$APP"

echo "==> Ativando modo de manutenção..."
php artisan down

echo "==> Instalando dependências PHP..."
composer install --no-dev --optimize-autoloader

echo "==> Compilando assets..."
npm install
npm run build

echo "==> Rodando migrations..."
php artisan migrate --force

echo "==> Reconstruindo cache de produção..."
php artisan optimize:clear
php artisan optimize
php artisan config:clear
php artisan route:cache
php artisan view:cache

echo "==> Desativando modo de manutenção..."
php artisan up

echo "==> Deploy concluído."
