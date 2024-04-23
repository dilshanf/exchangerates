### Exchange Rates

## Installation
1. Clone git repository
2. Run
````composer install````
3. Run
````php artisan key:generate````
4. Copy .env.example to .env and change the database connection (if needed)
5. Add openexchangerates API key to .env parameter OPEN_EX_RATES_KEY
6. Create new database (exchange_rates) as in .env file
7. Run
````php artisan migrate````
8. Run the application and background queue worker
````php artisan serve````
````php artisan queue:work````
9. Run get currencies command 
````php artisan currency:update````
10. Run get rates command
````php artisan rates:update````
11. Navigate to http://localhost:8080/rates/2024-04-23