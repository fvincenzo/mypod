# Introduction

Docker image for mypod based on Alpine Linux.  

## Setup

Install docker:
```
curl -sSL https://get.docker.com | sh
```

Install docker-compose:

Latest: v2.16.0

Installation command:
```
$ sudo curl -L "https://github.com/docker/compose/releases/download/v2.16.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
```

Provide correct permissions to docker compose:
```
$ sudo chmod +x /usr/local/bin/docker-compose
```

Test docker-compose:
```
$ docker-compose --version
```

## Usage

Create a `docker-compose.yml`:

```
# Docker composer file for mypod:latest
version: '3.8'

services:
  mypod:
    image: "ghcr.io/fvincenzo/mypod:latest"
    container_name: "mypod"
    command: sh -c "php-fpm81 && chmod 777 /var/run/php/php81-fpm.sock && nginx -g 'daemon off;'"
    environment:
      MYPOD_DOMAIN: http://localhost:8000
    volumes:
      - <podcasts>:/usr/share/nginx/html/podcasts
    ports:
      - "8000:80"
    restart: unless-stopped
```

Then, bring up the container:
```
docker-compose up
```