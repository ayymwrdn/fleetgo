FROM php:8.2-fpm

# Install dependencies (TAMBAHKAN pdo_pgsql)
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libzip-dev libpq-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy semua file
COPY . .

# ✅ BUAT .env DARI .env.example (TAPI KOSONGKAN DB SETTING)
RUN cp .env.example .env

# ✅ HAPUS KONFIGURASI MYSQL DI .env (biar pake DATABASE_URL)
RUN sed -i '/^DB_/d' .env

# ✅ COMPOSER INSTALL
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# ✅ KEY GENERATE
RUN php artisan key:generate

# ✅ OPTIMIZE (TANPA DB CONNECTION)
RUN php artisan config:cache || true
RUN php artisan route:cache || true
RUN php artisan view:cache || true

EXPOSE 8000

CMD ["sh", "-c", "php artisan migrate --force && php-fpm"]