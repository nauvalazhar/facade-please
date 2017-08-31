# Facade, please!
Sometimes you want to create a facade for globally accessible method, but you don't like doing it because you have to take a few steps. Facade, please! is a laravel package to solve your problem, just one command and your facade is ready to use!

# Installation
```
composer install facade-please
```
Add to `config/app.php`
```
'providers' => [
  ...
  Nauvalazhar\FacadePlease\FacadePleaseServiceProvider::class,
```

# Usage
### Create
```
php artisan facade:please YourFacade
```

### Delete
```
php artisan facade:delete YourFacade
```

### Configuration
```
php artisan vendor:publish --tag=facadeplease
```

# Credits
Thanks to @rizalio for any help!

# License
MIT License