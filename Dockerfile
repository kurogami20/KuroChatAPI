FROM --platform=linux/amd64 shinsenter/symfony:php8.4 AS build_amd64

COPY . /var/www/html/

EXPOSE 3000

RUN composer install --no-dev --optimize-autoloader

RUN symfony console doctrine:migrations:migrate --no-interaction

# CMD [ "symfony", "console", "doctrine:migrations:migrate", "--no-interaction" ]


