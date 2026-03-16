FROM shinsenter/symfony:latest

WORKDIR /app

COPY . .

EXPOSE 8000

CMD [ "symfony", "console", "doctrine:migrations:migrate", "--no-interaction", "&&", "symfony", "server:start", "--port=8000", "--allow-http" ]


