ARG APACHE_VERSION=""
FROM httpd:${APACHE_VERSION:+${APACHE_VERSION}-}alpine

RUN apk update; \
    apk upgrade;

RUN sed -i \
      -e 's/^#\(Include .*httpd-ssl.conf\)/\1/' \
      -e 's/^#\(LoadModule .*mod_ssl.so\)/\1/' \
      -e 's/^#\(LoadModule .*mod_socache_shmcb.so\)/\1/' \
      conf/httpd.conf

# Copy certificates
COPY server.crt /usr/local/apache2/conf/server.crt
COPY server.key /usr/local/apache2/conf/server.key

# Copy apache vhost file to proxy php requests to php-fpm container
COPY lumasms.conf /usr/local/apache2/conf/lumasms.conf
RUN echo "Include /usr/local/apache2/conf/lumasms.conf" \
    >> /usr/local/apache2/conf/httpd.conf
