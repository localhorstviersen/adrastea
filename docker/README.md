# Docker

The development environment is based on a Docker-Compose script, which builds and executes all necessary containers.

There are the following containers:

* PHP Apache
* Database (MariaDB 10.4.8)
* Portainer (container monitoring)
* Adminer (PhpMyAdmin Alternative)

## Run Docker Container

To run the Docker containers, you must first build the PHP Apache Docker image. To do this, run the command `docker-compose build`.

Next, all you have to do is `docker-compose up -d` and the docker containers are started and running in the background.

## Containers

### PHP-Apache

We use as base image the official [PHP-Apache Docker Image](https://hub.docker.com/_/php) with PHP version 7.2.

Die folgenden zusätzlichen PHP Erweiterungen werden im `Dockerfile` installiert:

* zip
* intl

Diese sind für das Ausführen von Codeigniter 4 erforderlich.

#### Environment Variablen

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
