## Tips

### NGINX / MariaDB custom configuration

Instead of using the default NGINX configuration you can use your own config file. Here is how you can use a custom configuration:

1. Create a folder and put your configuration inside it. E.g. `/config/nginx.conf`

2. Change `docker-compose.yml` to replace the default configuration by your custom config. The configuration would look like this:

```yml
# [...]
nginx:
  image: nginx:alpine
  volumes:
    - ./hosts:/etc/nginx/conf.d
    - ./files:/var/www
    - ./config/nginx.conf:/etc/nginx/nginx.conf # custom config entry
# [...]
```

For MariaDB the configuration is pretty much the same. Assuming the configuration is in `/config/mariadb.conf` the `docker-compose.yml` would look like this:

```yml
# [...]
mariadb:
  image: mariadb
  environment:
    - MYSQL_DATABASE=test_db
    - MYSQL_ROOT_PASSWORD=test_pass
  volumes:
    - ./mysql/database:/var/lib/mysql
    - ./config/mariadb.conf:/etc/mysql/conf.d # custom config entry
# [...]
```
You can find more about NGINX and MariaDB config files here:
- https://www.nginx.com/resources/wiki/start/topics/examples/full/
- https://mariadb.com/kb/en/mariadb/configuring-mariadb-with-mycnf/

### Adding PHP extensions

The official PHP docker image provides some helper scripts to more easily install PHP extensions. E.g. In order to install the mcrypt extension you should add the following line in `php.dockerfile`

```dockerfile
RUN docker-php-ext-install mcrypt
```

More about helper scripts: https://hub.docker.com/_/php/
