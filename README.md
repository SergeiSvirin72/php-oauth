# php-oauth
Клиент и сервер для Oauth2 авторизации с спользованием league/oauth2-server и doctrine

## Установка
Сгенерировать ключи командой:
```
./create_keys.sh
```
Развернуть проект:
```
docker-compose up
```
Подключиться к контейнеру сервера:
```
docker exec -it oauth-auth_server-1 bash
```
Выполнить миграции и наполнить базу тестовыми данными:
```
bin/doctrine migrations:migrate
bin/doctrine fixtures:load
```