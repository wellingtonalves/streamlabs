FROM php:7.4-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid
ARG pass

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libssl-dev \
    libpq-dev \
    libmemcached-dev \
    zip \
    unzip \
    supervisor \
    sudo \
    telnet \
    cron \
    vim

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install PHP extensions using Pecl
RUN pecl install apcu && docker-php-ext-enable apcu
RUN pecl install raphf && docker-php-ext-enable raphf
RUN pecl install propro && docker-php-ext-enable propro
RUN pecl install pecl_http-3.2.1 && docker-php-ext-enable http

# Install Memcached for php
RUN curl -L -o /tmp/memcached.tar.gz "https://github.com/php-memcached-dev/php-memcached/archive/refs/tags/v3.1.5.tar.gz" \
    && mkdir -p /usr/src/php/ext/memcached \
    && tar -C /usr/src/php/ext/memcached -zxvf /tmp/memcached.tar.gz --strip 1 \
    && docker-php-ext-configure memcached \
    && docker-php-ext-install memcached \
    && rm /tmp/memcached.tar.gz

# Install redis
RUN mkdir -p /usr/src/php/ext/redis \
    && curl -L https://github.com/phpredis/phpredis/archive/refs/tags/5.3.4.tar.gz | tar xvz -C /usr/src/php/ext/redis --strip 1 \
    && echo 'redis' >> /usr/src/php-available-exts \
    && docker-php-ext-install redis

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node 12
RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -
RUN apt-get install -y nodejs

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -p $(openssl passwd -crypt $pass) -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

RUN usermod -aG sudo $user

# Set working directory
WORKDIR /var/www

RUN export TERM=linux

COPY ./docker-entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh

COPY ./supervisor-laravel.conf /etc/supervisor/conf.d/supervisor-laravel.conf
COPY ./supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN echo "* * * * * root php /var/www/artisan schedule:run >> /var/log/cron.log 2>&1" >> /etc/crontab


ENTRYPOINT ["/docker-entrypoint.sh"]

#USER $user
