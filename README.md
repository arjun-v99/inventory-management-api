# Setup Instruction
1. Make sure you have installed PHP, Laravel and MySQL in your system
2. Clone the project from Github repository
3. After cloning, run the command `composer install`
4. Before starting up the app, make sure you create a copy of `.env.example` file and rename to `.env` and update the DB values with your PORT NUMBER, DB Name, DB User name and  password.
5. Run the command `php artisan migrate`
6. Run the command `php artisan db:seed`
7. Run the commadn `php artisan serve`. Now, the app will be boot up the 8000 Port. You can access it on `http://127.0.0.1:8000/`
8. You can API reuqests to the URL followed with `api/your_endpoint`. All the available endpoints can be found in the `routes/api.php` file.