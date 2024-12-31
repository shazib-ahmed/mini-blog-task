FROM php:8.2-apache

# Install necessary PHP extensions (pdo, pdo_mysql)
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache mod_rewrite (useful for many PHP apps, like Laravel)
RUN a2enmod rewrite

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Copy all project files into the container
COPY . /var/www/html

# Set proper permissions for the Apache user
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Ensure Apache runs in the foreground
CMD ["apache2-foreground"]
