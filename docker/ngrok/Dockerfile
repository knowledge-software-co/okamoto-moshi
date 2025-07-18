FROM --platform=linux/amd64 ngrok/ngrok:alpine

ENV TZ=Asia/Tokyo

USER root

RUN apk add --no-cache curl jq
# RUN curl -s localhost:4040/api/tunnels|jq -r ".tunnels[0].public_url"
