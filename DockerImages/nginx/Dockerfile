FROM nginx

MAINTAINER John

RUN apt-get update; apt-get install -y \
    openssl

RUN mkdir -p /etc/nginx/external
ADD nginx.conf /etc/nginx/

ARG PHP_UPSTREAM=php-fpm  


RUN  adduser -D -H -u 1000 -s /bin/bash www-data \
    && rm /etc/nginx/conf.d/default.conf \
    && echo "upstream php-upstream { server ${PHP_UPSTREAM}:9000; }" > /etc/nginx/conf.d/upstream.conf
ADD ssl_configure.sh /opt/ssl_configure.sh
RUN chmod a+x /opt/ssl_configure.sh
RUN /opt/ssl_configure.sh 
CMD ["nginx"]
EXPOSE 80 443