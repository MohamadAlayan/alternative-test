# Laravel Project Starter

A comprehensive starter kit for Laravel projects.

## Table of Contents

- [Project Description](#project-description)
- [Features](#features)
- [Requirements](#requirements)
- [Technologies Used](#technologies-used)
- [Packages](#packages)
- [Installation](#installation)
- [Commands](#commands)
- [Stackoverflow](#stackoverflow)
- [Documents](#documents)
- [TODO](#todo)

## Project Description
The Laravel Project Starter is a powerful and customizable boilerplate that serves as a starting point for building Laravel applications. It provides a solid foundation and essential features, enabling developers to jumpstart their projects with ease.
This project is designed to save time and effort by providing a pre-configured Laravel setup that incorporates best practices, industry-standard tools, and essential packages. It offers a structured directory layout, a modular architecture, and a collection of commonly used functionalities.
By using the Laravel Project Starter, developers can focus on building the unique aspects of their application rather than dealing with repetitive setup tasks. It comes with a range of features and integrations, including user authentication, role-based access control, database management, and API support, among others.
Whether you're starting a new web application, an API backend, or any other Laravel-based project, the Laravel Project Starter provides a solid foundation and a set of useful tools. It empowers developers to kickstart their projects with confidence, maintain a standardized codebase, and quickly build scalable and robust applications.

## Features
Admin Panel
- [x] Admin Authentication
  - [x] Login
  - [x] Forgot Password
  - [x] Reset Password
  - [x] Logout
  - [x] Logout All Devices
- [ ] Admin Management
  - [ ] Create Admin
  - [ ] Update Admin
  - [ ] Delete Admin
  - [ ] View Admin
  - [x] List Admins
  - [ ] Change Password
- [ ] User Management
  - [ ] Create User
  - [ ] Update User
  - [ ] Delete User
  - [ ] View User
  - [ ] List Users
  - [ ] Change Password

## Requirements
- PHP >= 8.1
- Enable PHP extensions: `mbstring`, `curl`, `exif`, `gd`, `pdo`, `tokenizer`, `xml`, `zip`
- MySQL >= 8.0
- Composer >= 2.1.9

## Technologies Used
- Laravel 10.x
- PHP 8.1
- MySQL 8.0
- PHPUnit

## Packages
- [Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar)
- [Laravel IDE Helper](https://github.com/barryvdh/laravel-ide-helper)
- [Laravel Permission](https://github.com/spatie/laravel-permission)
- [Laravel Telescope](https://github.com/laravel/telescope)
- [Laravel Log Viewer](https://github.com/ARCANEDEV/LogViewer)
- [Laravel Tinker](https://github.com/laravel/tinker)
- [Laravel Octane](https://github.com/laravel/octane)

## Installation
To get started with the Laravel Project Starter, follow the steps below:
1. Clone the repository:
```shell
git clone https://github.com/your-username/laravel-project-starter.git
```
2. Navigate to the project directory:
```
cd laravel-project-starter
```
3. Install the dependencies:
```shell
composer install
```
4. Create a copy of the `.env.example` file and rename it to `.env`:
```shell
cp .env.example .env
```
5. Generate an application key:
```shell
php artisan key:generate
```
6. Create a database for your application.
7. Update the `.env` file:
   1. update database credentials
       ```
       DB_CONNECTION=mysql
       DB_HOST=127.0.0.1
       DB_PORT=3306
       DB_DATABASE=your_database_name
       DB_USERNAME=your_database_username
       DB_PASSWORD=your_database_password
       ```
   
   2. update mail credentials
       ```
       MAIL_MAILER=smtp
       MAIL_HOST=smtp.sendgrid.net
       MAIL_PORT=587
       MAIL_USERNAME=apikey
       MAIL_PASSWORD=YOUR_SENDGRID_API_KEY
       MAIL_ENCRYPTION=tls
       MAIL_FROM_ADDRESS=your_email_address
       MAIL_FROM_NAME="${APP_NAME}"
       ```
8. Run the database migrations:
```shell
php artisan migrate
```
9. Start the local development server:
```shell
php artisan serve
```

## Commands

### Create a new controller
```shell
php artisan make:controller UserController
```

### Create a new model
```shell
php artisan make:model User
```

### Create a new migration
```shell
php artisan make:migration create_users_table
```

### Create a new seeder
```shell
php artisan make:seeder UsersTableSeeder
```

### Run database migrations
```shell
php artisan migrate
```

### Run fresh database migrations and seeders (this will delete all data and re-run migrations and seeders)
```shell 
php artisan migrate:fresh --seed
````

### Rollback database migrations
```shell
php artisan migrate:rollback
```

### Run database seeders
```shell
php artisan db:seed
```
### Clear all cache and config cache
```shell
php artisan optimize:clear
```

## Documents
- https://laravel.com/docs/10.x
- https://github.com/alexeymezenin/laravel-best-practices
- https://github.com/chiraggude/awesome-laravel

## Stackoverflow
- https://stackoverflow.com/questions/74301843/call-to-undefined-method-authuser-can-in-laravel-8-error
- https://stackoverflow.com/questions/68140778/using-laravel-8-with-sanctum-hasapitokens-to-login-with-a-remember-me-option/68627328#68627328

## TODO
- [ ] Add tests
- [ ] Add API documentation
- [ ] Upload Image
- [ ] Send Email
- [ ] Add Dashboard
- [ ] Add user activity log
- [ ] check log viewer in production
