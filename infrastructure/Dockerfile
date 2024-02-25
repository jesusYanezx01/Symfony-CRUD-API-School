# Dockerfile

FROM php:8.2-fpm

# Instalar Symfony
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Instalar dependencias y herramientas adicionales
RUN apt-get update && apt-get install -y \
        git \
        unzip \
        libzip-dev \
        openssh-server \
        libpq-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install zip \
    && docker-php-ext-install pdo pdo_pgsql
# Instalar extensión de PHP para PostgreSQL



# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos de la aplicación
COPY .. /var/www/html

# Instalar dependencias de Symfony
# RUN composer install --no-scripts --no-progress --no-suggest --prefer-dist

# Cambiar al usuario www-data (o el usuario no root que estés utilizando en tu imagen)
USER www-data

# Comando por defecto al iniciar el contenedor
CMD ["php-fpm"]