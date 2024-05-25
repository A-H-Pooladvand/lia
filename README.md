# Laravel Application Setup Guide

## Prerequisites

- Ensure you have [Composer](https://getcomposer.org/) installed.
- Ensure you have [Docker](https://www.docker.com/get-started) installed.

## Installation

1. **Clone the repository:**

    ```bash
    git clone git@github.com:A-H-Pooladvand/lia.git
    ```

2. **Install Composer dependencies:**

    ```bash
    composer install
    ```

3. **Setup Environment Configuration:**

    - Copy `.env.example` to `.env`:

        ```bash
        cp .env.example .env
        ```

    - Set `DB_CONNECTION` to `mongodb` in `.env`:

        ```env
        DB_CONNECTION=mongodb
        ```

    - Set `DB_URI` in `.env` (replace `USER`, `PASS`, `HOST`, and `PORT` with your MongoDB credentials):

        ```env
        DB_URI=mongodb://USER:PASS@HOST:PORT
        ```

    - Set `CACHE_STORE` to `redis` in `.env`:

        ```env
        CACHE_STORE=redis
        ```

4. **Setup Docker Containers:**

    - **MongoDB:**

        ```bash
        cd docker/mongodb
        docker compose up -d
        ```

    - **Redis:**

        ```bash
        cd docker/redis
        docker compose up -d
        ```

5. **Generate Application Key:**

    ```bash
    php artisan key:generate
    ```

6. **Run Migrations and Seed Database:**

    ```bash
    php artisan migrate --seed
    ```

7. **Generate Passport Keys:**

    ```bash
    php artisan passport:keys
    ```

8. **Create Password Grant Client:**

    ```bash
    php artisan passport:client --password
    ```

    - Copy the generated Client ID and Client Secret to the following in `.env`:

        ```env
        PASSPORT_PERSONAL_ACCESS_CLIENT_ID=your-client-id
        PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET=your-client-secret
        ```

## Running Tests

You can run the tests with:

```bash
./vendor/bin/phpunit
