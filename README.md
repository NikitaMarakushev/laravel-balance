Потенциальную проблему с доступам к файлам внутри смонитрованного каталога storage можно решить через команды

<h1>Команды ниже выполнять на host машине без перезапуска контейнеров</h1>

1) `sudo chmod -R gu+w storage`
2) `sudo chmod -R guo+w storage`
3) `php artisan cache:clear`

Запуск:
Запуск осуществляется через команду 
`docker compose up -d` или `docker-compose up -d`
Предварительно на хост машине должен быть установлен docker и docker compose https://docs.docker.com/engine/install/ubuntu/
В бразуере нужно открыть http://localhost

![img.png](img.png)

После запуска приложения необходимо запустить внутри контейнера с бекендом команду `php artisan queue:work` для обеспечения работоспособности функционала очередей, через который осуществляется проведение 
операций по балансу (уменьшение/увеличение)

Команды, представленные ниже, запускаются без аргументов в интерактивном режиме:
1) `php artisan user:create` - Создает пользователя и баланс на основе введенных данных
2) `php artisan process:balance` - Выполнят один из типов операций по балансу (увеличение суммы/уменьшение суммы)
