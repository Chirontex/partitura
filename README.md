# Partitura
Собственная CMS для блога.
Зачем? Да затем. Просто не хочу делать свой блог/сайт на Wordpress.

## Установка

### Быстрое создание dev-среды в docker-контейнере

1. Создать пустую директорию (например, __/partitura__) и клонировать в неё репозиторий: `git clone https://github.com/chirontex/partitura /partitura`.
2. Создать файл __/partitura/git-clone.sh__ следующего вида:
```bash
git config --global user.name <name>
git config --global user.email <email>
git clone https://<username>:<personal_access_token>@github.com/chirontex/partitura /www
```
3. Скопировать файл __/partitura/app/.env-example__ в __/partitura/.env__ и указать секретные данные.
4. Выполнить команды:
```bash
docker build -t partitura:latest .
docker run --rm -it -p 80:80/tcp -p 3306:3306/tcp -p 9003:9003/tcp partitura:latest
```
После этого можно подключаться к docker-контейнеру.

### Создание пользователя через CLI

Команда: `app/bin/console partitura:user:create <username> <password> [role]`

Роль обозначается кодом роли (значение поля __CODE__ в таблице __pt_roles__). Если не задано, то будет использоваться по умолчанию __ROLE_USER__.
