FROM dunglas/frankenphp:php8.5-trixie as base

# Installation des extensions PHP courantes pour Symfony
RUN install-php-extensions \
    pdo_pgsql \
    pdo_mysql \
    intl \
    zip \
    opcache \
    apcu \
    redis \
    gd \
    exif

WORKDIR /app

# Copier Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ============================================
# Stage de développement
# ============================================
FROM base AS dev

# Copier tous les fichiers du projet
COPY . /app

# Installer toutes les dépendances (y compris dev)
RUN composer install --prefer-dist --no-progress --no-interaction

# Créer les répertoires nécessaires
RUN mkdir -p var/cache var/log && \
    chown -R www-data:www-data var

# Configuration pour le développement
ENV APP_ENV=dev
ENV APP_DEBUG=1

EXPOSE 80 443

# ============================================
# Stage de production
# ============================================
FROM base AS prod

# Copier uniquement les fichiers nécessaires
COPY composer.json composer.lock symfony.lock ./
COPY .env .env.prod ./
COPY bin bin/
COPY config config/
COPY public public/
COPY src src/
COPY templates templates/
COPY translations translations/
COPY migrations migrations/

# Installer uniquement les dépendances de production
RUN composer install --prefer-dist --no-dev --no-progress --no-interaction --optimize-autoloader --classmap-authoritative


# Créer les répertoires et définir les permissions
RUN mkdir -p var/cache var/log && \
    chown -R www-data:www-data var && \
    chmod -R 775 var

RUN php bin/console lexik:jwt:generate-keypair --skip-if-exists

# Préchauffer le cache Symfony (utilise APP_ENV depuis .env.prod)
RUN APP_ENV=prod php bin/console cache:warmup

# Configuration pour la production
ENV APP_ENV=prod
ENV APP_DEBUG=0

# Activer le worker mode pour de meilleures performances en prod
ENV FRANKENPHP_CONFIG="worker ./public/index.php"

# Configuration Caddy pour la production
ENV SERVER_NAME=:80

EXPOSE 80 443
