# Redis + Redisinsight docker

This project provides a Docker Compose setup for running a Redis server (https://redis.io/) alongside Redis Insight (https://redis.io/docs/connect/insight/) for monitoring.

## Prerequisites

* Docker installed (https://docs.docker.com/engine/install/)
* Docker Compose installed (https://docs.docker.com/compose/install/)

## Environment Variables

* `REDIS_PORT`: (Optional) Port to expose for Redis. Defaults to 6379.
* `REDIS_INSIGHT_PORT`: (Optional) Port to expose for Redis Insight. Defaults to 5540.

## Usage

1. **Clone or Download the Repository:**
   ```bash
   git clone git@github.com:A-H-Pooladvand/redis-docker.git
   ```
2. **(Optional) Set Environment Variables:**
If you want to use ports other than the defaults, create a .env file in the project directory with the following content:

```
REDIS_PORT=your_redis_port
REDIS_INSIGHT_PORT=your_redis_insight_port
```
3. **Start the Services:**

```Bash
docker-compose up -d
```
This will start both Redis and Redis Insight containers in the background.

4. **Stop the Services:**

```Bash
docker-compose down
```
## Configuration
**Redis** is configured to use the official `redis:alpine` image. It automatically restarts unless stopped (`restart: unless-stopped`). You can optionally define custom ports using the `REDIS_PORT` environment variable.

**Redis Health Check** is included to ensure Redis is running before starting Redis Insight.

**Redis Insight** uses the `redis/redisinsight:latest` image and depends on the `redis` service with a `service_healthy` condition. This ensures Redis Insight starts only after Redis is healthy. It stores data in the `redis-insight-data` volume and exposes the management interface on the `REDIS_INSIGHT_PORT` (default: 5540).

**Volumes**

`redis-insight-data`: This volume persists Redis Insight data for later use.
## Accessing Redis Insight
Once the containers are running, you can access the Redis Insight web interface at `http://localhost:${REDIS_INSIGHT_PORT}` (e.g., `http://localhost:5540`).
