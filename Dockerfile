# Usa la imagen oficial de PHP 8.3 con FPM para producción
FROM php:8.3-fpm

# Instala las dependencias del sistema y extensiones requeridas
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl bcmath curl

# Instala la extensión de MongoDB
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Intala python3 y pip
RUN apt-get update && apt-get install -y python3 python3-pip

RUN pip install numpy

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www

# Copia los archivos de la aplicación a la imagen
COPY . .

# Instala las dependencias de Composer
RUN composer install --optimize-autoloader --no-dev

# Copia el archivo de configuración de PHP para producción
COPY ./docker/8.3/php.ini /usr/local/etc/php/

# Establece el propietario correcto de los archivos
RUN chown -R www-data:www-data /var/www

# Genera la clave de la aplicación
RUN php artisan key:generate

# Genera la caché de configuración
RUN php artisan optimize

# Ejecuta las migraciones
RUN php artisan migrate:fresh --seed

# Comando para iniciar PHP-FPM
CMD php artisan serve --host=0.0.0.0 --port=8080

# Expone el puerto que usará Laravel
EXPOSE 8080
