FROM php:7.2-fpm
#FROM php:8.0-fpm
# FROM php:7.2-fpm-alpine

RUN apt-get update && apt-get install -y \
		zip \
		unzip \		
		git \
		curl \
		libfreetype6-dev \
		libjpeg-dev \
		libjpeg62-turbo-dev \
		libpng-dev

RUN docker-php-ext-install zip gd pdo_mysql exif pcntl
RUN docker-php-ext-configure gd
#--with-freetype --with-jpeg
# RUN docker-php-ext-configure intl
# RUN docker-php-ext-install intl 
#RUN docker-php-ext-install -j$(nproc) gd

COPY ./compose/local/laravel/local.ini /usr/local/etc/php/conf.d/local.ini

USER root

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

ARG PUID=1000
ENV PUID ${PUID}

ARG PGID=1000
ENV PGID ${PGID}

RUN groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID}  -g www-data www-data

WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sL https://deb.nodesource.com/setup_14.x  | bash -
RUN apt-get -y install nodejs

#COPY ./compose/local/laravel/start /start
# COPY ./compose/local/laravel/start /start

# RUN sed -i 's/\r$//g' /start
# RUN chmod +x /start