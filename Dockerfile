FROM php:7.2.5

RUN apt-get update -y && apt-get install -y openssl zip unzip git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo mbstring
RUN pecl install mongodb \
    && echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/20-mongodb.ini

WORKDIR /app

# Copy over the dependencie files.
COPY composer.json ./
COPY composer.lock ./

# Install dependancies
RUN composer install --no-scripts --no-autoloader

# Add the app files
COPY ./ /app/

# Add the image env file
COPY ./.env.image ./.env

# Build the Autoloader
RUN composer dump-autoload --optimize

# Simple run of php app for development.
CMD php -S 0.0.0.0:8181 -t public

EXPOSE 8181
