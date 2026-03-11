FROM alpine:3.23

SHELL ["/bin/ash", "-eo", "pipefail", "-c"]

# Install build dependencies for PHP compilation
# hadolint ignore=DL3018
RUN apk add --no-cache \
    curl \
    zip \
    unzip \
    git \
    bash \
    autoconf \
    gcc \
    g++ \
    make \
    pkgconf \
    ca-certificates \
    linux-headers \
    re2c \
    bison \
    libxml2-dev \
    sqlite-dev \
    openssl-dev \
    curl-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libwebp-dev \
    libzip-dev \
    oniguruma-dev \
    icu-dev \
    libsodium-dev \
    argon2-dev \
    readline-dev \
    gmp-dev \
    postgresql16-dev \
    # Runtime deps
    libxml2 \
    openssl \
    libcurl \
    libpng \
    libjpeg-turbo \
    freetype \
    libwebp \
    libzip \
    oniguruma \
    icu-libs \
    libsodium \
    argon2-libs \
    readline \
    gmp \
    libpq

# Download and compile PHP 8.4 from source
WORKDIR /tmp
RUN curl -sSL https://github.com/php/php-src/archive/refs/tags/php-8.4.5.tar.gz -o php-src.tar.gz \
    && tar -xzf php-src.tar.gz

WORKDIR /tmp/php-src-php-8.4.5
RUN ./buildconf --force \
    && ./configure \
        --prefix=/usr/local \
        --with-config-file-path=/usr/local/etc/php \
        --with-config-file-scan-dir=/usr/local/etc/php/conf.d \
        --enable-fpm \
        --with-fpm-user=www \
        --with-fpm-group=www \
        --enable-mbstring \
        --enable-bcmath \
        --enable-intl \
        --enable-opcache \
        --enable-gd \
        --with-jpeg \
        --with-freetype \
        --with-webp \
        --with-zip \
        --with-curl \
        --with-openssl \
        --with-pdo-pgsql \
        --with-pgsql \
        --with-sodium \
        --with-password-argon2 \
        --with-readline \
        --with-gmp \
        --enable-xml \
        --enable-dom \
        --enable-simplexml \
        --enable-xmlwriter \
        --enable-xmlreader \
        --enable-ctype \
        --enable-session \
        --enable-fileinfo \
        --enable-tokenizer \
        --enable-phar \
        --with-iconv \
        --enable-sockets \
        --enable-pcntl \
        --with-zlib \
    && make -j"$(nproc)" \
    && make install \
    && rm -rf /tmp/php-src*

# Create PHP config directories
RUN mkdir -p /usr/local/etc/php/conf.d /usr/local/etc/php-fpm.d /var/log/php-fpm /run/php-fpm

# Install Redis extension from source (6.3.0 - supports PHP 8.4)
WORKDIR /tmp
RUN curl -sSL https://github.com/phpredis/phpredis/archive/refs/tags/6.3.0.tar.gz -o phpredis.tar.gz \
    && tar -xzf phpredis.tar.gz

WORKDIR /tmp/phpredis-6.3.0
RUN phpize \
    && ./configure \
    && make -j"$(nproc)" \
    && make install \
    && echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini \
    && rm -rf /tmp/phpredis*

COPY docker/php/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY docker/php/local.ini /usr/local/etc/php/conf.d/99-local.ini

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js
# hadolint ignore=DL3018
RUN apk add --no-cache nodejs npm

# Create working directory
WORKDIR /var/www

# Create a non-root user
RUN addgroup -g 1000 www && adduser -u 1000 -G www -s /bin/bash -D www

# Set permissions
RUN chown -R www:www /var/www /var/log/php-fpm /run/php-fpm

EXPOSE 9000

USER www

CMD ["php-fpm", "-F"]
