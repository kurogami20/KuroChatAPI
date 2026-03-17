FROM --platform=linux/amd64 shinsenter/symfony:php8.4 AS build_amd64

COPY . /var/www/html/

RUN composer install --no-dev --optimize-autoloader

EXPOSE 3000

# CMD [ "symfony", "console", "doctrine:migrations:migrate", "--no-interaction" ]


