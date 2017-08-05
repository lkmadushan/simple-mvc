Simple MVC
=========

Getting started
---------------

Download [Docker](https://www.docker.com/products/overview). If you are on Mac or Windows, [Docker Compose](https://docs.docker.com/compose) will be automatically installed. On Linux, make sure you have the latest version of [Compose](https://docs.docker.com/compose/install/).

Run in this directory:
```
docker-compose up -d
docker-compose exec app sh -c "composer install --no-interaction --no-progress --optimize-autoloader"
```

The app will be running at [http://localhost:8080](http://localhost:8080).