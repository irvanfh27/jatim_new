# Jatim New Core System
Build with Laravel and Vue js, using Dashio Admin Panel
## Installation
Clone the repo:
```shell
git clone https://github.com/irvanfh27/jatim_new
```

Install composer packages:
```shell
composer install
```

Copy and rename .env.example to .env, update the environmental variables and set an app key:
```shell
php artisan key:generate
```
Then setting your database in .env file:
```$xslt
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```
After that, run all migrations and seed the database:
```shell
php artisan migrate
```
```shell
php artisan db:seed
```

Or if your database is fresh and you haven't done any work yet, then it's safe to call the commands in a single line:
```shell
php artisan migrate:refresh --seed
```
next copy paste this command for authenticate API
```$xslt
php artisan passport:install
```
Note that seeding the database is compulsory as it will create the necessary roles and permissions for the user CRUD provided by the project.

Visit <div style="display: inline">http://yoursite.com/login</div> to sign in using below credentials:

#### Demo Admin Login
*  Email: admin@example.com
*  Password: 1234

P.S.: Password modification and user deletion is disabled in demo mode.

This project comes with a user CRUD and makes the use of [Spatie Roles and Permissions](https://github.com/spatie/laravel-permission) at a very basic level in order to give restricted access to the three roles provided above. You can move forward with the same logic to achieve more complex goals.

### Credits:
*   [Laravel](https://github.com/laravel/laravel)
*   [Spatie Laravel Roles and Permissions](https://github.com/spatie/laravel-permission)

### Contribution:
Contribution is welcomed and highly appreciated. Fork the repo, make your updates and initiate a pull request. I'll approve all pull requests as long as they are constructive and follow the Laravel standard practices.
