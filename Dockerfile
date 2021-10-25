FROM driftphp/base-php8

WORKDIR /var/www

#
# DriftPHP installation
#
COPY . .
RUN composer install -n --prefer-dist --no-dev --no-suggest && \
    composer dump-autoload -n --no-dev --optimize

COPY docker/* /

EXPOSE 8000
CMD ["sh", "/server-entrypoint.sh"]
