FROM php:8.2-apache

# Install necessary PHP extensions (pdo, pdo_mysql)
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Configure Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
COPY apache.conf /etc/apache2/sites-available/000-default.conf
RUN a2ensite 000-default.conf

# Set the working directory
WORKDIR /var/www/html

# Copy all project files into the container
COPY . .

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html
RUN find /var/www/html -type f -exec chmod 644 {} \;
RUN find /var/www/html -type d -exec chmod 755 {} \;

# Expose port 80
EXPOSE 80

# Ensure Apache runs in the foreground
CMD ["apache2-foreground"]
