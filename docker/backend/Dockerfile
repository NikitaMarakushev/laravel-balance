FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    libonig-dev \
    zip \
    libzip-dev \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    libpq-dev \
    curl && \
    pecl install xdebug-3.2.0 && \
    docker-php-ext-enable xdebug && \
    docker-php-ext-install pdo pdo_pgsql pgsql mbstring zip exif pcntl && \
    docker-php-ext-configure pgsql && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

RUN groupadd -g 1000 www && useradd -u 1000 -ms /bin/bash -g www www

USER www

EXPOSE 9000

CMD ["sh", "-c", "composer install && php artisan migrate && php artisan queue:work & php-fpm && fg"]
