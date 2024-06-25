# @make laravel-new-project
setup:
	@make build
	@make up
	@make composer-update
	@enable-laravel-storage

# @make data
# @make permission-user


# Comandos para incialização correta do projeto
build:
	sudo docker compose build --no-cache --force-rm

rebuild-up:
	sudo docker compose up --build --force-recreate

up:
	sudo docker compose up -d

# laravel-new-project:
# 	sudo docker container exec laravel-docker-app bash -c "composer create-project laravel/laravel ."

composer-update:
	sudo docker container exec laravel-docker-app bash -c "composer update"

permission-user:
	sudo chown -R marcos-saykache:marcos-saykache ./laravel-docker

permission-super-user:
	sudo chown -R www-data:www-data ./laravel-docker


# Ativar Laravel Fazer tudo na sequência (1)
enable-laravel-storage:
	cd storage/ && \
	mkdir -pv framework/views app/ framework/sessions framework/cache && \
	cd .. && \
	sudo chmod 775 -R storage && \
	sudo chown -R www-data:www-data storage


# Migrations e Seeds Fazer tudo na sequência (2)
laravel-migrate:
	sudo docker container exec laravel-docker-app bash -c "php artisan migrate"

laravel-seed:
	sudo docker container exec laravel-docker-app bash -c "php artisan db:seed"


# Comandos importantes
stop:
	sudo docker compose stop

stop-all:
	sudo docker container stop `sudo docker container ls -q`

exec-app:
	sudo docker container exec -it laravel-docker-app bash

apache-start:
	sudo docker container exec laravel-docker-app bash -c "apache2ctl -D FOREGROUND"


# Docker Manager
prune-volumes:
	sudo docker system prune --volumes

images:
	sudo docker image ls -a

containers-up:
	sudo docker container ls

containers-all:
	sudo docker container ls -a

container-permission-user:
	sudo docker container exec laravel-docker-app bash -c "chown -R root:root ./"


# Testes
# add-column-fotos:
# 	sudo docker container exec laravel-docker-app bash -c "php artisan make:migration add_photo_to_users_table --table=users"
# 	@make permission-user

# add-table:
# 	sudo docker container exec laravel-docker-app bash -c "php artisan make:model NomeDoModel -m"
# 	@make permission-user

# user-controller:
# 	sudo docker container exec laravel-docker-app bash -c "php artisan make:controller UserController -r"
# 	@make permission-user

# artisan-server:
# 	sudo docker container exec laravel-docker-app bash -c  "php artisan serve --port=9000"

login-system-create:
	sudo docker container exec laravel-docker-app bash -c "php artisan make:auth"

key-generate:
	sudo docker container exec laravel-docker-app bash -c "php artisan key:generate"

laravel-breeze-install:
	sudo docker container exec laravel-docker-app bash -c "composer require laravel/breeze --dev"
# Para a instalação do breeze deve ser executado tudo dentro do container (laravel-docker-app bash): "php artisan breeze:install"
# sudo docker container exec laravel-docker-app bash -c "php artisan breeze:install"

npm-install:
	sudo docker container exec laravel-docker-app bash -c "npm install"

npm-run-build:
	sudo docker container exec laravel-docker-app bash -c "npm run build"
