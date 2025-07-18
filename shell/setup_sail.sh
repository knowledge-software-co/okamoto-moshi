#!/bin/bash
# https://gist.github.com/niratama/b9611694f5f20d7819544a2399155cdc

# .envがなければエラー
if [ ! -e .env ]; then
    echo ".env.exampleをリネームして.envを作成してください。その後、ngrokとstripeのキーを設定してください。"
    exit 1
fi

# .envの環境変数を読み込む
export $(cat .env | grep -v ^# | xargs)

export APP_DIR=${APP_DIR:-$(pwd)}
export APP_SERVICE=${APP_SERVICE:-"laravel.test"}
export WWWUSER=${WWWUSER:-$UID}
export WWWGROUP=${WWWGROUP:-$(id -g)}
export SAIL_USER=${SAIL_USER:-"sail"}

run_container () {
    docker-compose run --rm --no-deps -e WWWUSER=${WWWUSER} -e WWWGROUP=${WWWGROUP} --volume="${APP_DIR}:/var/www/html" ${APP_SERVICE} "$@"
}

# if [ ! -e .env ]; then
#     cp .env.example .env
# fi

run_container composer install
run_container php artisan key:generate
