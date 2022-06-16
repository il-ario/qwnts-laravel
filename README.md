## FYI

### Built with Laravel
URL example: http://localhost:8080/api/users

- docker-compose.yml for PHP, MySQL, nginx
- .env file compiled
- JWT auth via Laravel Passport
- API: protected routes, controllers, sort, search
- Database: migrations, seeder, models, *user:create* command
- ForceJsonResponse middleware for JSON responses
- JSON response for 404 NotFoundHttpException

**Steps**

1. Clone repo
2. docker-compose up --build
3. php artisan migrate
4. php artisan passport:install --uuids
5. php artisan db:seed
6. php artisan user:create <params...>
