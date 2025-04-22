# Job Board

A Laravel 12-based RESTful API project for managing job listings and applications.

---

## Setup Instructions

### Prerequisites

- PHP 8.3+
- Composer
- MySQL (via Docker container)
- Docker

### 1. Clone the Repository

```bash
git clone https://github.com/abdelrhman-saeed/job-board.git
cd job-board
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Copy Environment File

```bash
cp .env.example .env
```

### 4. Configure `.env`

Adjust database credentials:

```
DB_CONNECTION=mysql
DB_HOST=mysql-container
DB_PORT=3306
DB_DATABASE=job_board
DB_USERNAME=root
DB_PASSWORD=secret

QUEUE_CONNECTION=database

CACHE_STORE=memcached
MEMCACHED_HOST=127.0.0.1
MEMCACHED_PORT=11211
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Run MySQL Docker Container

```bash
docker run --name mysql-container -e MYSQL_ROOT_PASSWORD=secret -p 3306:3306 -d mysql:latest
```

### 7. Run Memcached Docker Container

```bash
docker run -d --name memcached -p 11211:11211 memcached:latest
```

### 8. Run Migrations and seeders

```bash
php artisan migrate:fresh --seed

## Default Companies and Candidates are:

Companies:
1- email: company@mail.com
2- email: company2@mail.com

Candidates:
1- email: candidate@mail.com
2- email: candidate2@mail.com

passowrd: "password"
```

### 9. Passport Installation

```bash
php artisan passport:keys

php artisan passport:client --password --provider=companies --name="Company Password Client"

INFO  Password grant client created successfully.  

Here is your new client secret. This is the only time it will be shown so do not lose it!

Client ID ........................................................... Company Client id Placeholder
Client secret ................................................... Company Client Secret Placeholder

php artisan passport:client --password --provider=candidates --name="Candidate Password Client"

INFO  Password grant client created successfully.  

Here is your new client secret. This is the only time it will be shown so do not lose it!

Client ID ........................................................... Candidate Client id Placeholder
Client secret ................................................... Candidate Client Secret Placeholder
```

### 10. copy the client id and clients secret to the .env file

```bash
# .env
PASSPORT_COMPANY_PERSONAL_ACCESS_CLIENT_ID="Company Client id Placeholder"
PASSPORT_COMPANY_PERSONAL_ACCESS_CLIENT_SECRET="Company Client secret Placeholder"

PASSPORT_CANDIDATE_PERSONAL_ACCESS_CLIENT_ID="Candidate Client id Placeholder"
PASSPORT_CANDIDATE_PERSONAL_ACCESS_CLIENT_SECRET="Candidate Client secret Placeholder"
```

### 11. Set storage permissions

```bash
sudo chown -R www-data:www-data /path/to/your/project/storage

sudo find /path/to/your/project/storage -type d -exec chmod 775 {} \;
sudo find /path/to/your/project/storage -type f -exec chmod 664 {} \;
```

### 12. Run Queue Worker (optional)

```bash
php artisan queue:work
```

---

## API Endpoints

> Authentication

```http
obtain access token (JWT)

POST    /api/company/login
POST    /api/candidate/login

obtain refresh token

POST    /api/token/refresh
```

> Job CRUD

```http
GET         /api/jobs
GET         /api/jobs/{job}
POST        /api/jobs
PUT         /api/jobs/{job}
DELETE      /api/jobs/{job}
```

> Job Applications

```http
POST        /api/jobs/{job}/apply
GET         /api/candidate/jobs
```

---

## Nginx Configuration

Place this inside your Nginx config directory (e.g., `/etc/nginx/sites-available/job-board`):
> Note: you need to stop the apache service if you got it installed.

```nginx
server {
    listen 8000;
    server_name 127.0.0.1;

    root The path to the project public directory
    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }

    error_log /var/log/nginx/job-board_error.log;
    access_log /var/log/nginx/job-board_access.log;
}
```

### Enable and Restart Nginx

```bash
sudo ln -s /etc/nginx/sites-available/job-board /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```
## Postman Collection

You can test the API using the provided Postman collection:

[🔗 Download Collection](./JobBoard.postman_collection.json)

---

## You're All Set

## Design Choices

In this project, I chose to implement a modular approach, focusing on clean and maintainable code. The use of Laravel Passport ensures secure authentication with JWT tokens for both company and candidate users. I've also leveraged Laravel queues for handling background tasks to improve performance and ensure that long-running tasks do not block the main application flow.

Authentication: I've used passport for user authentication.

Database: The database configuration uses MySQL running in a Docker container for easy setup and portability.
It ensures consistency across environments.

Queues: Laravel's queue system was set up for handling background tasks like email notifications, ensuring that requests are not delayed by resource-intensive processes.

Separation of Concerns: I've followed MVC principles, organizing the logic in controllers, models, and views, with clear boundaries between them for easier testing and maintenance.

## Assumptions

Database Availability: The application assumes that a MySQL Docker container is already set up and running. The environment variable for database credentials should be set correctly in the .env file.

Environment: It's assumed that the application is being deployed on a Unix-like environment, with a proper Nginx and PHP-FPM setup. The Nginx configuration provided is based on the assumption that the public folder is the root directory.

Authentication Setup: The Laravel Passport authentication is assumed to be installed and configured correctly, including client ID and client secret, which should be defined in the .env file.

No heavy traffic initially: The current setup assumes moderate usage, so no high-availability configurations like load balancers or caching layers are added at this point.

## Improvements

Caching: To improve performance, especially for frequently accessed data like job posts or user details, I would implement caching mechanisms, either through Laravel’s built-in caching or by using Redis.

Rate Limiting: For security and to prevent abuse of the API, I would introduce rate limiting for certain endpoints (like authentication or job applications).

Testing: Although the app is functional, adding more unit and feature tests to ensure its stability and reliability across various use cases would be a great improvement.

Error Handling & Logging: I would enhance error handling and logging, especially for unexpected failures in queues or external API calls.

Scalability: The current setup would need adjustments for handling a large number of users or heavy traffic, such as adding database replication, load balancing, and horizontal scaling for the queue system.
