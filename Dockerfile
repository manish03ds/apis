FROM php:8.2-cli

WORKDIR /app
COPY . .

EXPOSE 10000

CMD ["php", "-S", "0.0.0.0:10000"]
FROM php:8.2-apache

# Install MySQL extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy project files
COPY . /var/www/html/

# Expose port
EXPOSE 80
