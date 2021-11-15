# evcsms ->Electric Vehicle Charging Station Management System.

## Requirements:

```
"php": "^7.3|^8.0",
        "laravel/framework": "^8.65",
        "laravel/passport": "^10.2",
        "laravel/sanctum": "^2.11",
        "laravel/tinker": "^2.5"
        
```


## API Routes:
```
Route::apiResource('station', StationController::class);
Route::apiResource('company', CompanyController::class);

```


## Tests

* run `php vendor/bin/phpunit`;
