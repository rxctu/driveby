FROM alpine:3.21

RUN apk add --no-cache nginx && \
    mkdir -p /run/nginx

COPY default.conf /etc/nginx/http.d/default.conf

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
