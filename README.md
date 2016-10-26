Simple Dockerised PHP environment for development using docker-compose.

- Uses only official images and recommended commands.
- No magic or tricky things.
- 3 separated containers. NGINX + PHP FPM + MariaDB
- Database is persisted in the host. You can stop and recreate containers without losing data.

## How to

Starting environment:
```sh
$ docker-compose up -d
```

Stopping environment:
```sh
$ docker-compose down
```

If you want to see containers output:
```sh
$ docker-compose logs
```

By default:
- Files from `/files/default` will be available at `http://localhost:8080`
- MariaDB created with database: test_db, user: root, password: test_pass
- You can change this configurations in the `docker-compose.yml`

Always restart the containers when changing configurations. Depending on the configuration changed maybe you will have to rebuild the images:
```
$ docker-compose build
```

More about docker-compose: https://docs.docker.com/compose/compose-file/


## About the structure
```
.
+-- /files
|   +-- /default
|   |   +-- index.php
+-- /hosts
|   +-- default.conf
+-- /mysql
|   +-- /database
+-- docker-compose.yml
+-- php.dockerfile
```
- `/files` - this directory is mapped to NGINX and PHP-FPM folders. Any file here will be accessible inside the containers.

- `/hosts` - this directory is mapped to `/etc/nginx/conf.d/`. Here you can put server blocks files that allow hosting more than one project at once.
The `default.conf` comes with an example host which listens on localhost and uses the files inside `/files/default`. If you are planning to use just one site maybe this is enough for your needs.
  - More about NGINX virtual hosts: https://www.nginx.com/resources/wiki/start/topics/examples/server_blocks/


- `/mysql/database` - directory where MariaDB files are stored. It makes possible databases information being persisted outside the containers.

- `docker-compose.yml` - contains most of the configurations. Feel free to edit as you wish.
  - Learn more about docker-compose file here https://docs.docker.com/compose/compose-file/


- `php.dockerfile` - This is used to install extensions in the PHP container (e.g. MariaDB PDO driver, mycript). You can add more extensions if necessary.
  - More about Dockerfiles: https://docs.docker.com/engine/reference/builder/
  - More about installing extensions using this PHP image: https://hub.docker.com/_/php/

## Images

- nginx:alpine https://hub.docker.com/_/nginx/
- php:7.1-fpm-alpine https://hub.docker.com/_/php/
- mariadb https://hub.docker.com/_/mariadb/


## Why?

How to provide a PHP environment for a beginner who is starting to learn on a Windows machine? That was my challenge.

Sure I've found other Dockerized PHP environment, but they didn't look beginner friendly. Reasons:
- Too many abstractions and options. Difficult to understand and requiring sometimes a lot of commands and tweaks.

or

- Too specific. The only way to work is the same way the maintainer does, with few options to customise.

This one intends to be simple but high customisable. It only depends on your needs, knowledge or time to follow the links provided :P.

If you need some help, have suggestions or issues feel free to contact me.

## Tips

Here are some tips that may be useful, but I choose to not include in the project because they are too specific and not part of the problem described:

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

### Multiple sites

### Adding PHP extensions

The official PHP docker image provides some helper scripts to more easily install PHP extensions. E.g. In order to install the mcrypt extension you should add the following line in `php.dockerfile`

```dockerfile
RUN docker-php-ext-install mcrypt
```

More about helper scripts: https://hub.docker.com/_/php/

### MariaDB / MySQL client

### Creating database dump
