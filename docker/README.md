# Docker

The development environment is based on a Docker-Compose script, which builds and executes all necessary containers.

There are the following containers:

* PHP Apache
* Database (MariaDB 10.4.8)
* Portainer (container monitoring)
* Adminer (PhpMyAdmin Alternative)

## Run Docker Container

To run the Docker containers, you must first pull all images. To do this, run the command `docker-compose pull`.

Next, all you have to do is `docker-compose up -d` and the docker containers are started and running in the background.

## Containers

### PHP-Apache

We are using the image `thecodingmachine/php:7.4-v4-apache-node14` from [TheCodingMachine](https://github.com/thecodingmachine/docker-images-php)

When starting the container with this image the command `composer install` will be executed. Also the container will install the following php extension:

- intl
- zip
- ldap
- json
- mysqli

#### Environment Variables

Via the environment variables you can make a variety of MariaDB configurations.

We have defined the following environment variables:

| Variable             | Inhalt               | Bemerkung                       |
|----------------------|----------------------|---------------------------------|
| APACHE_DOCUMENT_ROOT | /var/www/html/public | Path to Apache document root |

More about the environment variables can be found on the Docker Hub page of the image.

### Datenbank

We use the [MariaDB Docker Image](https://hub.docker.com/_/mariadb) version 10.4.8.

#### Environment Variablen

Via the environment variables you can make a variety of MariaDB configurations.

We have defined the following environment variables:

| Variable            | Inhalt   | Bemerkung                                |
|---------------------|----------|------------------------------------------|
| MYSQL_ROOT_PASSWORD | 123456   | Password of the `root` database user     |
| MYSQL_USER          | adrastea | Name of the database user                |
| MYSQL_PASSWORD      | 123456   | Password of the database user            |
| MYSQL_DATABASE      | adrastea | Name of the database being created |

More about the environment variables can be found on the Docker Hub page of the image.

### [Portainer](https://www.portainer.io/)

See Portainer [Docker Hub](https://hub.docker.com/r/portainer/portainer).

### [Adminer](https://www.adminer.org/)

See Adminer [Docker Hub](https://hub.docker.com/_/adminer).
