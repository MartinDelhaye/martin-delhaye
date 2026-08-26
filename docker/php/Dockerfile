FROM php:8.3-fpm

# Installe sqlite3 + headers nécessaires
RUN apt-get update && apt-get install -y \
    sqlite3 \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite

COPY sqlite /var/www/html/sqlite
WORKDIR /var/www/html
