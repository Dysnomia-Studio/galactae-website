FROM dysnomia/apache-server
WORKDIR /var/www/

# Build Project
COPY . /var/www/

RUN chown -R www-data:www-data /var/www/