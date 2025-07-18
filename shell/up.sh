SHELL=/bin/bash

cd "$(dirname "$0")"

# NGROK_URLが取得できない・もしくはnullの場合は、10回を限度にもう一度取得する
for i in {1..10};
do
    NGROK_URL=`docker compose exec ngrok sh -c "curl -s localhost:4040/api/tunnels|jq -r '.tunnels[0].public_url'"`
    if [ "$NGROK_URL" != "null" ] && [ -n "$NGROK_URL" ]; then
        break
    fi
    sleep 1
done

# .envと.env.testingのAPP_URLをNGROK_URLに書き換える
sed -i.bak -e "s@^APP_URL=.*@APP_URL=${NGROK_URL}@" ../.env
sed -i.bak -e "s@^APP_URL=.*@APP_URL=${NGROK_URL}@" ../.env.testing

rm -f ../.env.bak
rm -f ../.env.testing.bak
