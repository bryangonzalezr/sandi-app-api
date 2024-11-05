# Use the official PHP 8.3 with FPM image for production
FROM php:8.3-fpm

# Install system dependencies and required PHP extensions
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

# Install the MongoDB extension
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Install Google Chrome
RUN apt-get update && apt-get install -y wget \
    && wget -q https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb \
    && apt-get install -y ./google-chrome-stable_current_amd64.deb \
    && rm ./google-chrome-stable_current_amd64.deb

# Install dependencies needed for ChromeDriver
RUN apt-get update && apt-get install -y \
    libglib2.0-0 \
    libnss3 \
    libgconf-2-4 \
    libfontconfig1 \
    && apt-get clean

# Download the correct version of ChromeDriver using the Google Cloud Storage API
RUN CHROME_MAJOR_VERSION=$(google-chrome --version | grep -oP '\d+') && \
    CHROME_MINOR_VERSION=$(google-chrome --version | grep -oP '\d+\.\d+') && \
    CHROMEDRIVER_VERSION=$(curl -s https://storage.googleapis.com/chromium-chromedriver/LATEST_RELEASE_$CHROME_MAJOR_VERSION) && \
    gsutil cp gs://chromium-chromedriver/$CHROMEDRIVER_VERSION/chromedriver_linux64.zip /tmp/chromedriver.zip && \
    unzip /tmp/chromedriver.zip -d /usr/local/bin/ && \
    rm /tmp/chromedriver.zip

# Install Python 3, pip, and the virtual environment module
RUN apt-get update && apt-get install -y python3 python3-pip python3-venv

# Create a Python virtual environment
RUN python3 -m venv /opt/venv

# Activate the virtual environment and install required Python packages
RUN /opt/venv/bin/pip install --upgrade pip && \
    /opt/venv/bin/pip install numpy selenium webdriver-manager

# Ensure the virtual environment is available in the container
ENV PATH="/opt/venv/bin:$PATH"

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory
WORKDIR /var/www

# Copy the application files to the image
COPY . .

# Install Composer dependencies
RUN composer install --optimize-autoloader --no-dev

# Copy the PHP configuration file for production
COPY ./docker/8.3/php.ini /usr/local/etc/php/

# Ensure the correct ownership of the files
RUN chown -R www-data:www-data /var/www

# Generate the application key
RUN php artisan key:generate

# Generate the configuration cache
RUN php artisan optimize

# Run the migrations
RUN php artisan migrate:fresh --seed --force

# Command to start the Laravel server
CMD php artisan serve --host=0.0.0.0 --port=8080

# Expose the port used by Laravel
EXPOSE 8080
