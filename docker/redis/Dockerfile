FROM alpine:3.21

# hadolint ignore=DL3018
RUN apk add --no-cache redis

RUN mkdir -p /data && chown redis:redis /data

COPY redis.conf /etc/redis/redis.conf

EXPOSE 6379

USER redis
CMD ["redis-server", "/etc/redis/redis.conf"]
