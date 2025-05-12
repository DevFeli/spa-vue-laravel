FROM php:8.2-fpm

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    nano \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# # Ajusta limites de upload diretamente no PHP
RUN echo "upload_max_filesize=10M\npost_max_size=12M" > /usr/local/etc/php/conf.d/uploads.ini

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho
WORKDIR /var/www

# Copia os arquivos
COPY . .

# # Permissões
# RUN mkdir -p /var/www/storage/framework/cache/data \
#  && chmod -R 775 /var/www/storage /var/www/bootstrap/cache \
#  && chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Instala dependências do Laravel
RUN composer install

# Permissões
RUN chown -R www-data:www-data /var/www

EXPOSE 9000

CMD ["php-fpm"]