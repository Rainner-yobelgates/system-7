FROM ronaregen/php:apache-latest AS vendor

WORKDIR /app

COPY --chown=www-data:www-data . /app

RUN composer install \
    --ignore-platform-reqs \
    --no-ansi \
    --no-dev \
    --no-interaction \
    --no-scripts

# -----------------------------------------------
# Main stage for the final image
FROM ronaregen/php:apache-latest AS main

COPY php.ini /usr/local/etc/php/conf.d/
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
COPY --chown=www-data --from=vendor /app /var/www/html
COPY laravel.conf /etc/apache2/sites-available/000-default.conf

RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
