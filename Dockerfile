# =============================================================================
# Lensio CRM — Multi-stage Dockerfile
# Stage 1: node-builder  — Vite frontend assets
# Stage 2: php-builder   — Composer deps + app code
# Stage 3: final         — Nginx + PHP-FPM runtime (supervisord)
# =============================================================================

# ── Stage 1: Node / Vite build ───────────────────────────────────────────────
FROM node:20-alpine AS node-builder

WORKDIR /app

COPY package.json package-lock.json* ./
RUN npm ci --prefer-offline

COPY resources/ resources/
COPY vite.config.js ./
COPY public/ public/

RUN npm run build


# ── Stage 2: PHP extensions + Composer install ───────────────────────────────
FROM php:8.4-fpm-alpine AS php-builder

# ── 2a. Build-time system libraries ──────────────────────────────────────────
# NOTE: Do NOT include $PHPIZE_DEPS here — it is added separately for PECL
RUN apk add --no-cache \
    bash \
    git \
    curl \
    unzip \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    freetype-dev \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    libxml2-dev \
    postgresql-dev \
    linux-headers

# ── 2b. Compile PHP extensions that need to be explicitly installed ───────────
# Extensions already built into php:8.2-fpm-alpine (do NOT re-install):
#   ctype, dom, fileinfo, simplexml, tokenizer, pdo, xml, xmlreader, xmlwriter
# Extensions we need to add:
RUN docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install -j$(nproc) \
        pdo_pgsql \
        pgsql \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
        opcache

# ── 2c. Redis via PECL ───────────────────────────────────────────────────────
# $PHPIZE_DEPS is added and removed in one layer to keep image size down
RUN apk add --no-cache --virtual .phpize-deps $PHPIZE_DEPS \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .phpize-deps \
    && rm -rf /tmp/pear

# ── 2d. Composer binary ──────────────────────────────────────────────────────
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# ── 2e. Install PHP dependencies ─────────────────────────────────────────────
# Copy lockfiles first — this layer is cached unless deps change
COPY composer.json composer.lock ./

RUN composer install \
        --no-dev \
        --no-interaction \
        --no-progress \
        --optimize-autoloader \
        --no-scripts \
        --no-cache

# ── 2f. Copy full application source ─────────────────────────────────────────
COPY . .

# Bring in Vite-built assets from stage 1
COPY --from=node-builder /app/public/build public/build/

# Run post-autoload-dump now that the full app is present
RUN composer run-script post-autoload-dump --no-interaction 2>/dev/null || true

# Fix ownership / permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache


# ── Stage 3: Lean runtime image ──────────────────────────────────────────────
FROM php:8.4-fpm-alpine

LABEL maintainer="Lensio CRM"
LABEL description="Lensio CRM — PHP 8.4 + Nginx + PostgreSQL"

# ── 3a. Runtime system packages ──────────────────────────────────────────────
RUN apk add --no-cache \
    nginx \
    supervisor \
    bash \
    curl \
    libpng \
    libjpeg-turbo \
    libwebp \
    freetype \
    libzip \
    icu-libs \
    oniguruma \
    libxml2 \
    libpq

# ── 3b. Copy compiled extensions + ini files from builder ────────────────────
COPY --from=php-builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=php-builder /usr/local/etc/php/conf.d/     /usr/local/etc/php/conf.d/

# ── 3c. PHP & FPM config ─────────────────────────────────────────────────────
COPY docker/php/php.ini        /usr/local/etc/php/php.ini
COPY docker/php/www.conf       /usr/local/etc/php-fpm.d/www.conf

# ── 3d. Nginx config ─────────────────────────────────────────────────────────
COPY docker/nginx/nginx.conf   /etc/nginx/nginx.conf
COPY docker/nginx/default.conf /etc/nginx/http.d/default.conf

# ── 3e. Supervisor config ────────────────────────────────────────────────────
COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# ── 3f. Application code ─────────────────────────────────────────────────────
COPY --from=php-builder /var/www/html /var/www/html

WORKDIR /var/www/html

# ── 3g. Entrypoint ───────────────────────────────────────────────────────────
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
