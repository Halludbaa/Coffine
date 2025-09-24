FROM php:8.2-fpm-alpine

# Install essential packages and Apache
RUN apk add --no-cache \
    apache2 \
    apache2-proxy \
    apache2-ssl \
    curl \
    wget \
    zip \
    unzip \
    git \
    vim \
    nano

# Install PHP extensions
RUN apk add --no-cache \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    postgresql-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        gd \
        pdo \
        pdo_pgsql \
        zip \
        intl \
        mbstring \
        opcache \
        bcmath

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configure Apache
RUN mkdir -p /run/apache2 \
    && mkdir -p /var/log/apache2 \
    && mkdir -p /var/www/html/public

# Copy Apache configuration
COPY httpd.conf /etc/apache2/httpd.conf

# Copy PHP project files
COPY . /var/www/html/

# Set proper permissions
RUN chown -R apache:apache /var/www/html \
    && chmod -R 755 /var/www/html

RUN chown -R apache:apache /var/log/apache2 \
    && chmod -R 755 /var/log/apache2


# Expose port
EXPOSE 80

CMD ["sh", "-c", "php-fpm -D && httpd -D FOREGROUND"]