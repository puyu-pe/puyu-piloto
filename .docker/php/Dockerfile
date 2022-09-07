FROM php:8.1-fpm-bullseye
ARG TIMEZONE
ARG UID

# Install packages
RUN apt-get update && apt-get install -y \
    gnupg \
    g++ \
    procps \
    openssl \
    git \
    unzip \
    zlib1g-dev \
    libzip-dev \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev  \
    libonig-dev \
    libxslt1-dev \
    acl

# Install wkhtmltopdf
RUN apt-get install -y wkhtmltopdf

#config userapp
RUN adduser -u ${UID} --disabled-password --gecos "" appuser \
    && mkdir /home/appuser/.ssh \
    && chown -R appuser:appuser /home/appuser/ \
    && echo "StrictHostKeyChecking no" >> /home/appuser/.ssh/config \
    && echo "export COLUMNS=300" >> /home/appuser/.bashrc \
    && echo "alias sf='php bin/console'" >> /home/appuser/.bashrc

RUN #docker-php-ext-configure gd --with-jpeg --with-freetype

# Install PHP extenions
RUN docker-php-ext-install \
    mysqli pdo pdo_mysql zip xsl gd intl opcache exif mbstring soap \
    && pecl install xdebug \
    && docker-php-ext-enable --ini-name 05-opcache.ini xdebug

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
    && printf '[PHP]\date.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
    && "date"

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.3.10\
    && composer --version

# Config php.ini \
COPY php.ini /usr/local/etc/php/conf.d/docker-php-config.ini

# Config XDEBUG
COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Config php-fpm custom user
RUN sed -i "s/user = .*/user = appuser/" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = .*/group = appuser/" /usr/local/etc/php-fpm.d/www.conf

WORKDIR /var/www/html