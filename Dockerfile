FROM gbgmdl/website:7.0-apache-php
ADD ./src /var/www/html

RUN rm -f /var/www/html/Dockerfile.live \
 && rm -f /var/www/html/Dockerfile.migrate.live \
 && chmod 777 -R /var/www/html/app/_actions/ajaxHandler

