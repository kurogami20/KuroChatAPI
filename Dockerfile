FROM shinsenter/symfony:latest

WORKDIR /app

COPY . .

EXPOSE 8000

CMD [ "symfony", "console", "doctrine:migrations:migrate", "--no-interaction" ]


