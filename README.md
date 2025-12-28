## Stack
- PHP 8.1
- MySQL
- Smarty
- Docker (Nginx + PHP-FPM)

## Setup
1. Create MySQL database
2. Import database/schema.sql
3. Install dependencies:
   composer install
4. Seed database:
   php seed.php
5. Open:
   public/index.php

   ## Docker
Run:
docker-compose up -d --build

Open:
http://localhost:8080

Seed:
docker exec -it abelo_app php seed.php
