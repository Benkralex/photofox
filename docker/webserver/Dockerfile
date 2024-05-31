FROM php:7.4-apache

RUN git clone https://github.com/Benkralex/photofox /tmp/repo \
&& mkdir -p ./web \
&& cp -r /tmp/repo/code/* ./web/ \
&& php /var/www/html/configs/updateSQL.php \
&& docker exec -i db mysql -uroot -prootpass < ./web/configs/photofoxDB.sql \
&& rm -rf /tmp/repo

COPY ./configs/* ./web/configs/