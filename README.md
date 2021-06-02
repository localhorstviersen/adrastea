# Adrastea

Adrastea is a ticket system, it was written in PHP using the framework CodeIgniter 4.

## Folder Structure

In the folder `src/` you will find the source code of the ticket system.

Under `docker/` you can find all necessary docker files.

## Installation

### Using Docker

When using Docker, the following steps must be performed:

1. Switch to the docker directory `cd ./docker`
1. Run `docker-compose pull` to pull all docker images.
    - Maybe you want to change the credentials of the mariadb database in the `docker-compose.yml` file.
1. Copy `src/.env.example` to `src/.env`
    1. You have to change the following environment settings to the one you need:
        - `ldap.host`
        - `ldap.base.dn`
        - `ldap.suffix`
1. Run `docker-compose up -d` and visit `http://127.0.0.1`

See more to Docker [here](https://github.com/localhorstviersen/adrastea/tree/develop/docker).