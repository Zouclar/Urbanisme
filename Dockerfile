FROM php:8.1-fpm

# Installer les dépendances nécessaires pour Symfony
RUN apt-get update && apt-get install -y libzip-dev zip

# Installer Node.js et npm
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash -
RUN apt-get install -y nodejs

# Installer Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN rm composer-setup.php

# Installer Symfony CLI
RUN curl -sL https://cli.symfony.com/download | bash
RUN mv /root/.symfony-cli/bin/symfony /usr/local/bin/

WORKDIR /app

CMD ["php-fpm"]