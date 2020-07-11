FROM dysnomia/apache-server
WORKDIR /var/www/

# Build Project
COPY . /var/www/

ENTRYPOINT ["/bin/bash"]
CMD ["service", "apache2", "start"];
CMD ["service", "php7.4-fpm", "start"];