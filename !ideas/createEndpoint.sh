#bash

php artisan make:model Country -crmf
php artisan make:request Api/Country/CountryIndexRequest
php artisan make:request Api/Country/CountryUpdateRequest
php artisan make:request Api/Country/CountryStoreRequest
php artisan make:request Api/Country/CountryDeleteRequest
php artisan make:request Api/Country/CountryShowRequest
php artisan make:seeder CountrySeeder
php artisan make:resource CountryResource
php artisan make:resource CountriesResource --collection
php artisan make:test CountryTest
php artisan make:factory CountryFactory



php artisan migrate
php artisan migrate --env=testing
