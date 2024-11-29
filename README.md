## Structure

Backend is the Laravel APIs

Frontend is the Vue Application

## Dockerized!

### Build the images and run them
`docker compose up -d`

### Setup the Laravel Backend

Access the backend container's terminal with `docker exec -it backend sh`

Run:

`php artisan key:generate`

`php artisan migrate`

### Visit the app

[http://localhost:8080/](http://localhost:8080/)