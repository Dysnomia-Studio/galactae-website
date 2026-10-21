FROM ghcr.io/dysnomia-studio/apache-server:main
WORKDIR /var/www/

COPY . /var/www/

RUN chown -R www-data:www-data /var/www/
