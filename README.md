# Partitura
Собственная CMS, на которой я потом сделаю свой блог.

Почему так?
1. Это полезно.
2. Нет желания делать свой блог на готовых (чужих) CMS.

## Установка

### Быстрое создание dev-среды в docker-контейнере

0. Создать форк этого репозитория.
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
Проброс портов можно варьировать в зависимости от ваших технических возможностей и предпочтений.
5. Добавить в файл hosts следующую запить:
```
127.0.0.1 partitura.loc
```
Клиентская часть CMS будет доступна по указанному выше адресу.

После этого можно подключаться к docker-контейнеру.

__P.S.__ Оригинальный адрес репозитория везде заменяем на адрес своего форка, конечно же.

## Команды CLI

### Создание пользователя

Команда: `app/bin/console partitura:user:create <username> <password> [role]`

Роль обозначается кодом роли (значение поля __CODE__ в таблице __pt_roles__). Если не задано, то будет использоваться по умолчанию __ROLE_USER__.

### Смена пароля пользователя

Команда: `app/bin/console partitura:user:change-password <username> <password>`

В качестве значения аргумента __password__ передаётся новый пароль.
