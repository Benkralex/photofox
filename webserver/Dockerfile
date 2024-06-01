FROM php:7.4-apache


RUN apt-get update \
    && apt-get install -y default-mysql-client \
    && docker-php-ext-install mysqli \
    && mkdir -p /var/www/html

# Set the working directory
WORKDIR /var/www/html

# Ensure permissions are set properly
RUN chown -R www-data:www-data /var/www/html

# Copy the wait script
COPY wait-for-db.sh /usr/local/bin/wait-for-db.sh
