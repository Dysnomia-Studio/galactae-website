FROM ghcr.io/dysnomia-studio/apache-server:main
WORKDIR /var/www/

# Build Project
COPY . /var/www/

RUN chown -R www-data:www-data /var/www/