# 2024/11/01 MakefileはTaskfileに移行しました。今後Makefileはメンテナンスされません。Taskfileを使用してください。

SHELL=/bin/bash
MYID:=$(shell id -u)
MYGROUP:=$(shell id -g)
DIR:=$(shell pwd)

include .env

# ngrokのURLを固定しない場合は、ngrokのURLを毎回取得する
#up:
#	./vendor/bin/sail up -d
#	sh ./shell/up.sh
#	@make cache
#	./vendor/bin/sail exec ngrok sh -c "curl -s localhost:4040/api/tunnels|jq -r '.tunnels[0].public_url'"
up:
	./vendor/bin/sail up -d
build:
# docker-compose build --no-cache --force-rm
	./vendor/bin/sail build --no-cache
create-project:
	@make build
	@make up
	./vendor/bin/sail composer create-project --prefer-dist laravel/laravel .
	docker compose exec laravel.test chmod -R 777 storage bootstrap/cache
install-recommend-packages:
	./vendor/bin/sail composer require doctrine/dbal
	./vendor/bin/sail composer require --dev barryvdh/laravel-ide-helper
	./vendor/bin/sail composer require --dev beyondcode/laravel-dump-server
	./vendor/bin/sail composer require --dev barryvdh/laravel-debugbar
	./vendor/bin/sail composer require --dev roave/security-advisories:dev-master
	./vendor/bin/sail artisan vendor:publish --provider="BeyondCode\DumpServer\DumpServerServiceProvider"
	./vendor/bin/sail artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"
init:
#	./vendor/bin/sail -d --build
#	./vendor/bin/sail composer install
#	docker run --rm -u "$(id -u):$(id -g)" -v $(pwd):/var/www/html -w /var/www/html laravelsail/php84-composer:latest composer install --ignore-platform-reqs
	docker run --rm -u "$(MYID):$(MYGROUP)" -v "$(DIR)":/var/www/html -w /var/www/html laravelsail/php84-composer:latest composer install --ignore-platform-reqs

# if WWWGROUP and WWWUSER is defined
#	docker compose exec laravel.test cp .env.example .env

# if WWWGROUP and WWWUSER is not defined
#	docker exec -it 20230622_curva-laravel.test-1 cp .env.example .env

#	sh ./shell/setup_sail.sh

	@make create-test-env
	@make create-dusk-env

	@make up
#	sh ./shell/up.sh

	./vendor/bin/sail artisan key:generate
	./vendor/bin/sail artisan storage:link
	./vendor/bin/sail artisan migrate:fresh --seed

	@make cache

	git config --local core.hooksPath .githooks

#	@make create-self-signed-cert

	@make npm
	@make npm-dev
create-test-env:
#	sed -e "s/DB_HOST=mysql/DB_HOST=mysql.test/" ./.env > ./.env.testing
	sed -e "s/DB_DATABASE=.*/DB_DATABASE=testing/" ./.env > ./.env.testing
	sed -i.bak -e "s/APP_ENV=local/APP_ENV=testing/" ./.env.testing
#	sed -i.bak -e "s/DB_PORT=3306/DB_PORT=3306\nFORWARD_DB_PORT=3300/" ./.env.testing
	rm -f ./.env.testing.bak
create-dusk-env:
	sed -e "s/DB_DATABASE=.*/DB_DATABASE=testing/" ./.env > ./.env.dusk.local
	sed -i.bak -e "s/APP_ENV=local/APP_ENV=testing/" ./.env.dusk.local
	rm -f ./.env.dusk.local.bak

	echo "DUSK_DRIVER_URL=http://selenium:4444/wd/hub" >> .env.dusk.local
	echo "TELESCOPE_ENABLED=false" >> .env.dusk.local
	echo "NODE_ENV=dusk" >> .env.dusk.local

remake:
	@make destroy
	@make init
stop:
	./vendor/bin/sail stop
down:
	./vendor/bin/sail down
restart:
#	@make down
#	@make up
	docker restart laravel.test
destroy:
	docker-compose down --rmi all --volumes
destroy-volumes:
	docker-compose down --volumes
ps:
	docker-compose ps
logs:
	docker-compose logs
logs-watch:
	docker-compose logs --follow
shell:
	./vendor/bin/sail shell
shell-root:
	./vendor/bin/sail root-shell
mysql:
	./vendor/bin/sail mysql
migrate:
	./vendor/bin/sail artisan migrate
fresh:
	./vendor/bin/sail artisan migrate:fresh --seed
	@make cache-clear-cache
	rm -rf ./storage/app/public/line-rich-menus/*
# rm -rf ./storage/app/public/product-images/[0-9]*
seed:
	./vendor/bin/sail artisan db:seed
seed-postalcode:
	./vendor/bin/sail php artisan import:postal-code
rollback-test:
	./vendor/bin/sail artisan migrate:fresh
	./vendor/bin/sail artisan migrate:refresh

command-list:
	./vendor/bin/sail artisan list

delete-all-rich-menus-for-line-server:
	./vendor/bin/sail artisan command:delete-all-rich-menus-for-line-server

tinker:
	./vendor/bin/sail artisan tinker
# echo Str::plural('book');
pint:
	./vendor/bin/sail php ./vendor/bin/pint
pint-test:
	./vendor/bin/sail php ./vendor/bin/pint --test -v
test:
	@make npm-prod

	./vendor/bin/sail artisan config:clear
	./vendor/bin/sail artisan migrate:fresh --seed --env=testing
#	./vendor/bin/sail artisan test --env=testing
#	./vendor/bin/sail artisan test
	@make pest
#	@make pest-coverage
	@make dusk
	@make phpstan
	@make vue-test

#	./vendor/bin/sail php ./vendor/bin/duster lint
	./vendor/bin/sail php ./vendor/bin/duster lint --using="tlint,phpcs,php-cs-fixer"
	./vendor/bin/sail npm run lint
pest:
	./vendor/bin/sail artisan config:clear
	./vendor/bin/sail php ./vendor/bin/pest
pest-coverage:
	./vendor/bin/sail artisan config:clear
#	./vendor/bin/sail php ./vendor/bin/pest --coverage
	./vendor/bin/sail php ./vendor/bin/pest --coverage --min=80

# stop vite before running
dusk:
	@if [ -f "public/hot" ]; then echo "警告: 'public/hot' ファイルが存在します。処理を終了します。"; exit 1; fi

	./vendor/bin/sail artisan config:clear
	./vendor/bin/sail artisan pest:dusk
#	./vendor/bin/sail dusk
phpstan:
	./vendor/bin/sail php ./vendor/bin/phpstan analyse -c phpstan.neon
duster-fix:
	./vendor/bin/sail php ./vendor/bin/duster fix
vue-test:
	./vendor/bin/sail npm test run
vue-test-coverage:
	./vendor/bin/sail npm run test:coverage

# pretterは以下のコマンドを使用してください
vue-format:
	./vendor/bin/sail npm run format

# php artisan optimize is
# do php artisan config:cache
# do php artisan route:cache
# php artisan view:cache is not execution
optimize:
	./vendor/bin/sail artisan optimize
	./vendor/bin/sail artisan view:cache

# php artisan optimize:clear is
# do
optimize-clear:
	./vendor/bin/sail artisan optimize:clear
	./vendor/bin/sail artisan clear-compiled
#./vendor/bin/sail php artisan cache:clear
#./vendor/bin/sail php artisan config:clear
#./vendor/bin/sail php artisan route:clear
#./vendor/bin/sail php artisan view:clear
cache-dev:
	./vendor/bin/sail composer dump-autoload
	@make optimize

#release = dump-autoload -o
#dev = dump-autoload
cache:
	./vendor/bin/sail composer dump-autoload
	@make optimize
cache-clear:
	@make optimize-clear
#	./vendor/bin/sail artisan lighthouse:clear-cache
	@make npm-cache-clear
	./vendor/bin/sail artisan modelCache:clear
#	./vendor/bin/sail artisan telescope:prune
	./vendor/bin/sail artisan telescope:clear
	./vendor/bin/sail artisan clockwork:clean
	@make log-clear
	@make clockwork-log-clear
cache-clear-cache:
	@make cache-clear
	@make cache
dump-autoload:
	./vendor/bin/sail composer dump-autoload

log-clear:
	rm -rf ./storage/logs/*.log
clockwork-log-clear:
	rm -rf ./storage/clockwork/*.json

composer-remove:
	rm -rf ./vendor
composer-reinstall-dev:
	@make composer-remove
	./vendor/bin/sail composer install --optimize-autoloader --no-interaction --no-progress --prefer-dist
composer-reinstall-prod:
	@make composer-remove
	./vendor/bin/sail composer install --no-dev --optimize-autoloader --no-interaction --no-progress --prefer-dist

# maintenance mode
maintenance:
	./vendor/bin/sail artisan down --render="errors::maintenance" --secret="kidsc0me"
maintenance-cancel:
	./vendor/bin/sail artisan up

npm:
	@make npm-i
npm-i:
	./vendor/bin/sail npm i --legacy-peer-deps
npm-i-prod:
# ./vendor/bin/sail npm i --production --legacy-peer-deps
	./vendor/bin/sail npm i --production
npm-dev:
	./vendor/bin/sail npm run dev
npm-prod:
	./vendor/bin/sail npm run build
npm-watch:
	./vendor/bin/sail npm run watch
npm-watch-poll:
	./vendor/bin/sail npm run watch-poll
npm-hot:
	./vendor/bin/sail npm run hot
npm-cache-clear:
#	./vendor/bin/sail npm cache verify && ./vendor/bin/sail npm cache clean --force
	./vendor/bin/sail npm cache verify
npm-refresh-dev:
	rm -rf node_modules
	rm -f package-lock.json
	@make npm-cache-clear
	@make npm-i
npm-refresh-prod:
	rm -rf node_modules
	rm -f package-lock.json
	@make npm-cache-clear
# @make npm-i-prod
	@make npm-i
npm-update:
	./vendor/bin/sail root-shell
	npm install -g npm@latest

# npm-check-updates for local
# https://alpacat.com/posts/npm-check-updates
npm-package-update-check:
	ncu
npm-package-edit:
	ncu -u
npm-package-update:
	@make npm i

# Commands for periodic updates
periodic-updates:
	./vendor/bin/sail composer update
	@make npm-package-update-check
	@make npm-package-edit
	@make npm-package-update

yarn:
	./vendor/bin/sail yarn
yarn-install:
	@make yarn
yarn-dev:
	docker compose exec web yarn dev
yarn-watch:
	docker compose exec web yarn watch
yarn-watch-poll:
	docker compose exec web yarn watch-poll
yarn-hot:
	docker compose exec web yarn hot
redis:
	docker compose exec redis redis-cli
ide-helper:
	./vendor/bin/sail artisan clear-compiled
	./vendor/bin/sail artisan ide-helper:generate
	./vendor/bin/sail artisan ide-helper:meta
	./vendor/bin/sail artisan ide-helper:models --nowrite
route-list:
	./vendor/bin/sail artisan route:list
pull:
	git checkout develop
	git pull origin develop
	git checkout user/kkimura
	git merge develop
run-storybook:
	./vendor/bin/sail npm run storybook
run-npm:
	./vendor/bin/sail npm run

filament-resouce:
	./vendor/bin/sail artisan make:filament-resource User --generate --soft-deletes --view

scribe-generate:
	./vendor/bin/sail artisan scribe:generate

schemaspy-recreate:
	./vendor/bin/sail up schemaspy

# Local execution of GitHub Actions using act
act:
	act pull_request --container-architecture linux/amd64

create-self-signed-cert:
	openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout domain.key -out signed.crt -subj "/CN=localhost" -addext "subjectAltName=DNS:localhost" -addext "extendedKeyUsage=serverAuth"

# memo for aws
aws-mysql:
	mysql -h awseb-e-ybfpuhjhkg-stack-awsebrdsdatabase-i6ro6cllvqtq.c5de3brr5n1w.ap-northeast-3.rds.amazonaws.com -P 3306 -u root -p
	select * from ebdb.users where email = sekainotacchan@gmail.com;
aws-fresh:
	sudo -u webapp php -d memory_limit=-1 artisan migrate:fresh --seed
aws-migrate:
	sudo -u webapp php -d memory_limit=-1 artisan migrate
aws-composer-v:
	sudo -u webapp /usr/bin/composer.phar -v
aws-composer-cache:
	sudo -u webapp php artisan cache:clear
	sudo -u webapp /usr/bin/composer.phar dump-autoload
	sudo -u webapp php artisan config:cache

zip-aws:
	zip ../laravel-default.zip -r * .[^.]* -x "vendor/*" "node_modules/*" "__MACOSX/\*" "*.DS_Store"

# aws development env
remake-dev:
	@make cache-clear
	cp -f .env.development .env
# @make composer-reinstall-dev
	@make cache
	@make npm-refresh-dev
	@make npm-dev
	@make log-clear
	@make clockwork-log-clear
	zip ../laravel-dev.zip -r * .[^.]* -x "vendor/*" "__MACOSX/\*" "*.DS_Store" ".schemaspy/*" ".scribe/*" "docs/*"
remake-staging:
	@make cache-clear
	@make log-clear
	cp -f .env.staging .env
	@make cache
	@make npm-refresh-dev
	@make npm-dev
	zip ../laravel-staging.zip -r * .[^.]* -x "vendor/*" "__MACOSX/\*" "*.DS_Store" ".schemaspy/*" ".scribe/*" "docs/*"
remake-production:
	@make cache-clear
	cp -f .env .env.bak
	cp -f .env.production .env
# @make composer-reinstall-prod
	@make cache
	rm -rf ./public/hot
	@make npm-refresh-prod
	@make npm-prod
	@make log-clear
	@make clockwork-log-clear
	rm -rf ./storage/app/public/line-rich-menus/*
	zip ../laravel-prod.zip -r * .[^.]* -x "vendor/*" "__MACOSX/\*" "*.DS_Store" ".schemaspy/*" ".scribe/*" "docs/*"

	cp -f .env.bak .env
	rm -f .env.bak
	@make cache

# local env
remake-local:
#	@make log-clear
#	cp -f .env.example .env
# @make composer-reinstall-dev
	@make cache-clear
	@make cache
	@make npm-refresh-dev
	@make npm-dev
