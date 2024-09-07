# Use the official PHP 8.3 image with FPM for production
FROM php:8.3-fpm

# Install system dependencies and extensions required for both PHP and Python
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
    python3 \
    python3-pip \
    python3-venv \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl bcmath curl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Create a Python virtual environment
RUN python3 -m venv /opt/venv

# Activate the virtual environment and install Python packages
RUN . /opt/venv/bin/activate && pip install --upgrade pip && pip install numpy

# Ensure that the virtual environment's Python and pip are used globally
ENV PATH="/opt/venv/bin:$PATH"

# Instala la extensión de MongoDB
RUN pecl install mongodb && docker-php-ext-enable mongodb

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
