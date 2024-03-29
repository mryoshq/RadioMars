# Admin Panel Guide

Welcome to the yDays Admin Guide. This document aims to help you navigate through database migration, seeding, API usage, and more within our Laravel application. Let's get started with setting up your environment and dive into the details of how to manage your database and explore the API functionalities.

## Table of Contents

1. [Database Migration and Seeding Guide](#database-migration-and-seeding-guide)
   - [Database Configuration](#database-configuration)
   - [Database Migration](#database-migration)
   - [Database Seeding](#database-seeding)
   - [Refreshing Migrations and Seeds](#refreshing-migrations-and-seeds)
2. [API Documentation](#api)
   - [Authentication](#authentication)
   - [Errors](#errors)
   - [Endpoints](#endpoints)
3. [Observations and Notes](#observations-and-notes)

## Database Migration and Seeding Guide

This section covers the necessary steps to configure, migrate, and seed your MySQL database for the Laravel application.

### Database Configuration

1. Rename `.env.example` to `.env` in your project directory.
2. Update your `.env` file with the database configuration:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1 // or your MySQL server IP
DB_PORT=3306 // your MySQL server port, default is 3306
DB_DATABASE=homestead // replace with your database name
DB_USERNAME=homestead // replace with your user name
DB_PASSWORD=secret // replace with your password

### Database Migration

After configuring your `.env` file, it's time to run database migrations. Migrations allow you to modify your database schema in a structured way.

Execute the following Artisan command to migrate:

```bash```
php artisan migrate
bash
Copy code
php artisan migrate
This command will create tables in your database based on the migration files found in the database/migrations directory.

### Database Seeding
Database seeding is the process of filling your database with data. This data can be testing data or default data like roles or admin user.

To run database seeds, use the db:seed Artisan command:

bash
php artisan db:seed
This command will populate your tables with data based on the seed files found in the database/seeders directory.

After you've run these commands, your application's database will be set up and populated with data.

### Refreshing Migrations and Seeds
If you want to rollback all your migrations, migrate them again and re-run the seeders, you can use the migrate:refresh command along with the --seed option:

bash
php artisan migrate:refresh --seed

This will give you a fresh start if you need to clear out your database for any reason.

Note: Please make sure that you've installed all the dependencies using composer install command before running migration and seeding commands.

For more information, you can refer to the official Laravel documentation:

Migrations: https://laravel.com/docs/8.x/migrations
Seeding: https://laravel.com/docs/8.x/seeding



##  API
To explore the API, I have generated comprehensive documentation using the Scribe package. You can access this documentation at http://localhost:8000/docs

The documentation includes descriptions of the endpoints, the required parameters, the responses, as well as examples to help you understand how to use each endpoint.

### Authentication
This API uses Laravel Sanctum for authentication. The register and login endpoints return a token which needs to be included in the Authorization header in the format Bearer {token} for authenticated requests.

### Errors
Errors are returned in the following format:

json
{
  "message": "Error message",
  "errors": {
    "field": [
      "Error related to this field"
    ]
  }
}


### Endpoints
Here are the general categories of endpoints available:

Authentication: Register, login and logout endpoints.
Advertiser: Get and update advertiser's information.
Ads: CRUD operations on ads.
Payments: CRUD operations on payments.




# observations and notes

'allowed_methods' url to be replaced with the react url in cors.php file

## Special Kudos

A big thank you to everyone who contributed to this guide. Special kudos to @mryoshq for writing and compiling this comprehensive documentation. Your efforts make it easier for everyone to navigate and utilize the Admin Panel functionalities efficiently.
