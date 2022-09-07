FROM nginx:1.20
ARG TIMEZONE

ARG UID
ARG APP_NAME

RUN adduser -u ${UID} --disabled-password --gecos "" appuser

COPY nginx.conf  /etc/nginx/
COPY default.conf /etc/nginx/conf.d/
# RUN echo "upstream php-upstream { server ${APP_NAME}_php:9000; }" > /etc/nginx/conf.d/upstream.conf

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone

# Enable permission to logs
RUN chown appuser:appuser -R /var/log/nginx/

EXPOSE 80
EXPOSE 443
