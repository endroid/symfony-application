FROM nginx:1.13.3

RUN apt-get update && apt-get install -y vim nano python-certbot-nginx --fix-missing

ADD nginx.conf /etc/nginx/nginx.conf
ADD ssl /etc/nginx/ssl

#RUN certbot --nginx -d endroid.nl --non-interactive

RUN usermod -u 1000 www-data

CMD ["nginx"]

WORKDIR /var/www/html

EXPOSE 80 443
