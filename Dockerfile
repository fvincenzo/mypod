FROM alpine:latest

WORKDIR /usr/share/nginx/html

RUN apk update && apk upgrade
RUN apk add bash
RUN apk add nginx
RUN apk add php81 php81-fpm php81-opcache
RUN apk add php81-gd php81-zlib php81-curl
RUN apk add composer

COPY server/etc/nginx /etc/nginx
COPY server/etc/php /etc/php81
COPY workspace/src /usr/share/nginx/html

RUN mkdir /var/run/php

RUN adduser $(whoami) nginx
RUN chown -R nginx:nginx /usr/share/nginx/html
RUN chmod -R 755 /usr/share/nginx/html; find /usr/share/nginx/html -type d -print0 | xargs -0 chmod 755

RUN composer require james-heinrich/getid3