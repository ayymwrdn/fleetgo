FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libzip-dev libpq-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy semua file
COPY . .

# ✅ BUAT .env DARI .env.example
RUN cp .env.example .env

# ✅ COMPOSER INSTALL
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# ✅ KEY GENERATE (pake env dari Render)
RUN php artisan key:generate

# ✅ OPTIMIZE
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# ✅ SET PERMISSION
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache
RUN chmod -R 775 /app/storage /app/bootstrap/cache

EXPOSE 8000

CMD ["sh", "-c", "php artisan migrate --force && php-fpm"]