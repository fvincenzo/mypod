FROM alpine:latest

RUN apk update && apk upgrade
RUN apk add bash
RUN apk add nginx

# Install packages not yet updated for the current alpine version TODO remove when no longer needed
RUN echo 'https://dl-cdn.alpinelinux.org/alpine/v3.16/community' >> /etc/apk/repositories
RUN echo 'https://dl-cdn.alpinelinux.org/alpine/v3.16/main' >> /etc/apk/repositories
RUN apk add php8 php8-fpm php8-opcache
RUN apk add php8-gd php8-zlib php8-curl

COPY server/etc/nginx /etc/nginx
COPY server/etc/php /etc/php8
COPY workspace/src /usr/share/nginx/html

RUN mkdir /var/run/php

RUN adduser $(whoami) nginx
RUN chown -R nginx:nginx /usr/share/nginx/html
RUN chmod -R 755 /usr/share/nginx/html; find /usr/share/nginx/html -type d -print0 | xargs -0 chmod 755