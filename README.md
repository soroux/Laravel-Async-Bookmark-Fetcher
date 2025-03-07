# Laravel Async Bookmark Fetcher

This application allows users to insert a URL, fetch metadata asynchronously using RabbitMQ, and update the database.

## Features
- **Asynchronous Processing:** Uses RabbitMQ for background tasks.
- **Containerized Setup:** Runs with Docker Compose.
- **RESTful API:** Provides endpoints for managing bookmarks.

## Prerequisites
- **Docker & Docker Compose** installed on your machine.

## Installation

1. **Clone the repository:**
   ```sh
   git clone https://github.com/your-repo.git
   cd your-repo
2. **Create environment file:**
   ```sh
   cp .env.example .env
3. **Update .env file with database and RabbitMQ credentials:**
4. **Start the containers:**
   ```sh
   docker-compose up -d --build
5. **Run database migrations:**
   ```sh
   docker exec -it ${APP_NAME}_app php artisan migrate

## API Documentation

The API endpoints are provided in the Postman collection located in the root directory.

## Docker Setup

### Services

- **App**: Laravel application ([`docker/php/Dockerfile`](docker/php/Dockerfile)).
- **MySQL**: Database service.
- **Nginx**: Serves the Laravel app ([`docker/nginx/default.conf`](docker/nginx/default.conf)).
- **RabbitMQ**: Message broker for async processing.
- **Worker**: Processes RabbitMQ jobs ([`docker/worker/Dockerfile`](docker/worker/Dockerfile)).


### Ports

- **App (Nginx)**: `8080`
- **MySQL**: `${DB_PORT}:3306`
- **RabbitMQ**: `5672` (AMQP) / `15672` (Management UI)

## Worker Service

The worker container runs with Supervisor to handle queued jobs. Ensure it's running:

```sh
docker logs -f laravel_worker
```

## Debugging

- **Check container logs**:
  ```sh
  docker logs -f ${APP_NAME}_app
  ```
- **Access application shell**:
  ```sh
  docker exec -it ${APP_NAME}_app bash
  ```
