FROM chirontex/lemp:1.0.0

RUN mkdir /www \
    mkdir /temp

COPY git-clone.sh /temp/git-clone.sh
COPY .env /temp/.env
COPY partitura.conf /etc/nginx/conf.d/partitura.conf

ENTRYPOINT service php8.1-fpm start \
    && php -r "file_put_contents('/etc/hosts', \"127.0.0.1\tpartitura.loc\n\".file_get_contents('/etc/hosts'));" \
    && php -r "file_put_contents('/etc/mysql/mariadb.conf.d/50-server.cnf', str_replace('bind-address', '#bind-address', file_get_contents('/etc/mysql/mariadb.conf.d/50-server.cnf')));" \
    && bash /temp/git-clone.sh \
    && cp /temp/.env /www/app/.env \
    && cd /www/app \
    && composer install \
    && mkdir /www/logs \
    && service nginx start \
    && service mariadb start \
    && mysql_secure_installation < /mysql_secure_installation_answers.txt \
    && rm /mysql_secure_installation_answers.txt \
    && sudo -i mysql -uroot -proot < /www/docker_initial.sql \
    && rm -rf /temp \
    && echo "SUCCESSFULLY FINISHED!" \
    && touch /var/log/container.log \
    && tail -F /var/log/container.log

EXPOSE 80
EXPOSE 3306
EXPOSE 9003
