FROM wordpress:latest
WORKDIR /var/www/html

# Install PHP extensions SOAP
RUN apt-get update && apt-get install -y \
    libxml2-dev \
    && docker-php-ext-install soap
