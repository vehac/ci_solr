#!/bin/bash

echo "------------------ Permissions folder ---------------------"
bash -c 'chmod -R 777 /var/www/html/application/cache'

bash -c 'chmod -R 777 /var/www/html/upload/data-solr00'

echo "------------------ Starting apache server ------------------"
exec "apache2-foreground"