php artisan key:generate
php artisan migrate



# Authentication
// Add: composer.json: "tymon/jwt-auth": "1.0.0-rc.1"
composer update

## config/app.php
Adding "Tymon\JWTAuth\Providers\JWTAuthServiceProvider::class," to config/app.php
Adding Aliases: 'JWTAuth' => Tymon\JWTAuth\Facades\JWTAuth::class,
                   'JWTFactory' => Tymon\JWTAuth\Facades\JWTFactory::class

```                   
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
php artisan jwt:generate
```

(In case jwt:generate is not working, go to JWTGenerateCommand and replace method-name "fire" with "handle")

config/cors.php
Add ```'exposedHeaders' => ['Authorization'],```


config/auth.php
Change app\User.php to app\Models\User.php

config/hashing.php
'driver' => 'argon',

## Exception Handling

```composer require optimus/heimdal ~1.0```

config/app.php add

```Optimus\Heimdal\Provider\LaravelServiceProvider::class,```

Publish Conf

```php artisan vendor:publish --provider="Optimus\Heimdal\Provider\LaravelServiceProvider" ```

Add/Replace the exception handler to bootstrap/app.php

```
$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    Optimus\Heimdal\ExceptionHandler::class
);
```


