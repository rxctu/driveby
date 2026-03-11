FROM alpine:3.23

# hadolint ignore=DL3018
RUN apk add --no-cache nginx && \
    mkdir -p /run/nginx \
             /var/lib/nginx/tmp/client_body \
             /var/lib/nginx/tmp/proxy \
             /var/lib/nginx/tmp/fastcgi \
             /var/lib/nginx/tmp/uwsgi \
             /var/lib/nginx/tmp/scgi \
             /var/log/nginx && \
    chown -R nginx:nginx /var/lib/nginx /var/log/nginx /run/nginx

COPY default.conf /etc/nginx/http.d/default.conf

EXPOSE 80

USER nginx

CMD ["nginx", "-g", "daemon off;"]
