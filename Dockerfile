FROM php:8.2-apache

# Install dependencies untuk PostgreSQL (Supabase) & ekstensi PHP
RUN apt-get update && apt-get install -y libpq-dev zip unzip \
    && docker-php-ext-install pdo pdo_pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy semua file kodinganmu ke dalam mesin
COPY . .

# Install library Laravel
RUN composer install --no-dev --optimize-autoloader

# Beri izin akses untuk folder storage (INI YANG BIKIN VERCEL ERROR)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Ubah root folder Apache ke folder public Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Aktifkan mod_rewrite Apache (agar URL tidak error 404)
RUN a2enmod rewrite

# Buka jalur untuk Render
EXPOSE 80