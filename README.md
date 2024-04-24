### Exchange Rates

## Installation
1. Clone git repository
2. Run
````composer install````
````php artisan key:generate````
3. Copy .env.example to .env and change the database connection (if needed)
4. Add openexchangerates API key to .env parameter OPEN_EX_RATES_KEY
5. Create new database (exchange_rates) as in .env file
6. Run the database migration
````php artisan migrate````
7. Run the application and background queue worker
````php artisan serve````
````php artisan queue:work````
8. Run get currencies command 
````php artisan currency:update````
9. Run get rates command
````php artisan rates:update````
10. Navigate to http://localhost:8080/rates?date=2024-04-24

11. Run api test command
```` composer test ````