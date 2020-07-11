FROM dysnomia/apache-server
WORKDIR /var/www/

# Build Project
COPY . /var/www/