FROM php:8.3-cli

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libzip-dev

# Install PHP extensions
RUN docker-php-ext-install zip pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install

# Set the command to run PHPUnit tests
CMD ["vendor/bin/phpunit", "--configuration", "phpunit.xml"]
