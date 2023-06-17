# ydays_admin
## Database Migration and Seeding Guide
This Laravel application uses a MySQL database. To get started, you will need to have a MySQL server setup and credentials for a database user who has permissions to create and modify databases.

Here are the steps to follow:

### Database Configuration
Rename .env.example to .env in your project directory.

Update the database configuration in your .env file:

less

DB_CONNECTION=mysql
DB_HOST=127.0.0.1 // or your MySQL server IP
DB_PORT=3306 // your MySQL server port, default is 3306
DB_DATABASE=homestead // replace with your database name
DB_USERNAME=homestead // replace with your user name
DB_PASSWORD=secret // replace with your password
Database Migration
After setting up the .env file, you can run database migrations. Migrations are like version control for your database, they allow you to modify your database schema in a structured and organized way.

To run migrations, use the migrate Artisan command:

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
To explore the API, I have generated comprehensive documentation using the Scribe package. You can access this documentation at http://localhost:8000/docs.

The documentation includes descriptions of the endpoints, the required parameters, the responses, as well as examples to help you understand how to use each endpoint.

### Authentication
This API uses Laravel Sanctum for authentication. The register and login endpoints return a token which needs to be included in the Authorization header in the format Bearer {token} for authenticated requests.

### Errors
Errors are returned in the following format:

json
Copy code
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