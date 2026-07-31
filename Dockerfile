FROM php:8.3-apache

COPY . /var/www/html/

RUN a2enmod rewrite \
    && chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type d -exec chmod 775 {} \; \
    && find /var/www/html -type f -exec chmod 664 {} \; \
    && printf '#!/bin/sh\nset -e\n: "${PORT:=10000}"\nsed -i "s/Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf\nsed -i "s/<VirtualHost \\*:[0-9][0-9]*/<VirtualHost *:${PORT}/" /etc/apache2/sites-available/000-default.conf\nexec apache2-foreground\n' > /usr/local/bin/render-start \
    && chmod +x /usr/local/bin/render-start

EXPOSE 10000

CMD ["render-start"]
