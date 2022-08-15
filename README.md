# CodeIgniter
Docker - CodeIgniter 3.1.13 (PHP 7.4) - MariaDB - Solr 8.11.2 (Solarium 6.2.3)

## Inicio
- Crear carpeta `upload/data-solr00` y darle permisos de lectura y escritura, esta carpeta servirá como volumen para Solr
- Crear carpeta `upload/driver-solr/dataimporthandler/lib` y agregar el driver `mysql-connector-java-8.0.30.jar` para conectar java y mysql, enlace de descarga ([mysql-connector-java](https://dev.mysql.com/downloads/connector/j))
- En la ruta `docker/php` se encuentra el archivo `init.sh` donde se asigna permisos a las carpetas `application/cache` y `upload/data-solr00`
- Se agrega el archivo `.htaccess` donde se coloca regla para omitir el `index.php` de las url's
- Se agrega el archivo `application/config/ci_solr.php` donde se encuentran las credenciales para conectar a Solr
- Se modifica el archivo `application/config/config.php` para permitir tener una url base en `['base_url']`, omitir el `index.php` en las url's en `['index_page']` y permitir cargar la carpeta `vendor` en `['composer_autoload']`
- Se modifica el archivo `application/config/config.php` para guardar las sesiones, esto en la variable `['sess_save_path']`
- Se modifica el archivo `application/config/autoload.php` para agregar el helper `url` en `['helper']`
- Se modifica el archivo `application/config/autoload.php` para agregar las librerías `session` y `form_validation` en `['libraries']`
- Se modifica el archivo `application/config/database.php` donde se agrega las credenciales para conectarse a la BD
- Se modifica el archivo `application/config/routes.php` para tener por default la ruta `home`
- Se crea la carpeta `application/solr/articles/conf` donde se encuentran los archivos `db-connection.xml`, `db-data-config.xml`, `managed-schema` y `solrconfig.xml` para Solr, que son necesarios para el core `articles` que se va a crear

## Docker
- Para la primera vez que se inicia el proyecto con docker o se cambie los archivos de docker ejecutar:
```bash
sudo docker-compose up --build -d
```
- En las siguientes oportunidades ejecutar:

Para iniciar:
```bash
sudo docker-compose start
```
Para detener:
```bash
sudo docker-compose stop
```
- Para ingresar al contenedor con php ejecutar:
```bash
sudo docker-compose exec webserver bash
```
- Instalar las dependencias con composer, para ello, dentro del contenedor con php ejecutar:
```bash
composer install
```
- Para ingresar al contenedor con solr ejecutar:
```bash
sudo docker-compose exec solr bash
```

## MariaDB
- En la primera vez luego de iniciar docker; loguearse al contenedor con mariadb y luego cargar la data del archivo `docker/my_db.sql` en la BD `my_db` con `SOURCE <ruta_de_my_db.sql>`
```bash
mysql -u root -p -h 14.25.22.18
3*DB6ci9
use my_db;
SOURCE /var/www/html/ci_solr/docker/my_db.sql
```

## Sorl
- Luego de iniciar el contenedor con php (webserver) y luego de cargar la data del archivo `docker/my_db.sql` en la BD `my_db`, 
crear el core `articles`
```bash
docker exec -it ci_solr solr create_core -c articles
```
- Detener los contenedores
```bash
sudo docker-compose stop
```
- Iniciar los contenedores
```bash
sudo docker-compose start
```
- Copiar los archivos de la carpeta `application/solr/articles/conf` en `upload/data-solr00/data/articles/conf`
- Luego de copiar los archivos ir a `http://localhost:9483/solr/#/~cores/articles` y hacer reload del core articles
- Ahora ir a `http://localhost:9483/solr/#/articles/dataimport//dataimport` y hacer un dataimport para cargar los datos de la BD en Solr
- Para ver el proyecto desde un navegador:

Sin virtualhost:
```bash
http://localhost:8484
```
Con virtualhost:

Si se usa Linux, agregar en `/etc/hosts` de la pc host la siguiente linea:
```bash
14.25.22.19    local.solr.com
```
## Referencias
- [https://solarium.readthedocs.io/en/stable](https://solarium.readthedocs.io/en/stable)
- [https://github.com/solariumphp/solarium](https://github.com/solariumphp/solarium)
- [https://solr.apache.org/downloads.html](https://solr.apache.org/downloads.html)
- [https://solr.apache.org/guide/solr/latest/deployment-guide/solr-in-docker.html](https://solr.apache.org/guide/solr/latest/deployment-guide/solr-in-docker.html)
- [https://cwiki.apache.org/confluence/display/SOLR/Apache+Solr+Wiki](https://cwiki.apache.org/confluence/display/SOLR/Apache+Solr+Wiki)
- [https://cwiki.apache.org/confluence/display/solr/DIHQuickStart](https://cwiki.apache.org/confluence/display/solr/DIHQuickStart)
- [https://github.com/docker-solr/docker-solr](https://github.com/docker-solr/docker-solr)