# Usa la imagen oficial de PHP 8.3 con FPM para producción
FROM php:8.3-fpm

# Instala dependencias del sistema y extensiones requeridas para PHP
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

#Instalar google chrome
RUN apt-get update && apt-get install -y wget
RUN wget -q https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb
RUN apt-get install -y ./google-chrome-stable_current_amd64.deb

# Instala librerias necesarias para chromedriver
RUN apt-get update && apt-get install -y libglib2.0-0 \
    libnss3 \
    libgconf-2-4 \
    libfontconfig1 \
    chromium-chromedriver \
    chromium-browser

# Instala Python 3, pip y el módulo para crear entornos virtuales
RUN apt-get update && apt-get install -y python3 python3-pip python3-venv

# Crea un entorno virtual para Python
RUN python3 -m venv /opt/venv

# Activa el entorno virtual y luego instala numpy
RUN /opt/venv/bin/pip install --upgrade pip && /opt/venv/bin/pip install numpy
RUN /opt/venv/bin/pip install selenium && /opt/venv/bin/pip install webdriver-manager

# Asegura que el entorno virtual esté disponible en el contenedor
ENV PATH="/opt/venv/bin:$PATH"

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
RUN php artisan migrate:fresh --seed --force

# Comando para iniciar Laravel Server y Reverb en paralelo
CMD php artisan serve --host=0.0.0.0 --port=8080

# Expone los puertos que usará Laravel y Reverb
EXPOSE 8080
