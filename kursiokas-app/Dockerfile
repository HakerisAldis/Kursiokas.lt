FROM php:7.4-cli
EXPOSE 8000
COPY . /usr/src/kursiokas
WORKDIR /usr/src/kursiokas
RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git && \
    apt-get install -y unzip

RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql

ENTRYPOINT ["php", "start.sh"]
