# Utilisez l'image PHP officielle avec la version 8.2 et Apache
FROM php:8.2-apache

# Installez les dépendances nécessaires
RUN apt-get update \
    && apt-get install -y \
        libicu-dev \
        libzip-dev \
        unzip

# Activez les extensions PHP nécessaires
RUN docker-php-ext-install \
    intl \
    zip

# Activez le module Apache mod_rewrite
RUN a2enmod rewrite

# Copiez les fichiers de l'application dans le conteneur
COPY . /var/www/html

# Définissez le répertoire de travail
WORKDIR /var/www/html/public

# Installez les dépendances du projet Symfony
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-scripts --no-autoloader


# Exposez le port 80 pour le serveur Apache
EXPOSE 80

# Démarrez le serveur Apache
CMD ["apache2-foreground"]
