FROM alpine:3.9

RUN apk add --update nginx \
    && rm -rf /var/cache/apk/* \
    && mkdir -p /run/nginx

ADD ./nginx.conf /etc/nginx/nginx.conf

EXPOSE 80

CMD ["nginx"]
