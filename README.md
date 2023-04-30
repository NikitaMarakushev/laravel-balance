![postgresql](https://img.shields.io/badge/PostgreSQL-316192?style=for-the-badge&logo=postgresql&logoColor=white)
![php](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)
![Docker](https://img.shields.io/badge/docker-%230db7ed.svg?style=for-the-badge&logo=docker&logoColor=white)
![Vite](https://img.shields.io/badge/vite-%23646CFF.svg?style=for-the-badge&logo=vite&logoColor=white)
![jQuery](https://img.shields.io/badge/jquery-%230769AD.svg?style=for-the-badge&logo=jquery&logoColor=white)

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

Команды, представленные ниже, запускаются без аргументов в интерактивном режиме:
1) `php artisan user:create` - Создает пользователя и баланс на основе введенных данных
2) `php artisan process:balance` - Выполнят один из типов операций по балансу (увеличение суммы/уменьшение суммы)
