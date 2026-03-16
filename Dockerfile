FROM shinsenter/symfony:latest

COPY . /var/www/html/

EXPOSE 3000

# CMD [ "symfony", "console", "doctrine:migrations:migrate", "--no-interaction" ]


