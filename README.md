# Facade, please!
Sometimes you want to create a facade for globally accessible method, but you don't like doing it because you have to take a few steps. Facade, please! is a laravel package to solve your problem, just one command and your facade is ready to use!

# Requirements
- PHP >= 5.4.*
- Laravel 5

# Installation
```
composer require nauvalazhar/facade-please
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
The Generated facade will be stored in the `app/MyFacades` folder by default, but you can change the destination folder in the `config/facadeplease.php` file. Before doing that, you need to do [this step](#configuration).

### Delete
```
php artisan facade:delete YourFacade
```

### Configuration
```
php artisan vendor:publish --tag=facadeplease
```

# Changelogs
```
0.2.0 - Hope you love this
-----

New
---
- Optional argument for command: php artisan facade
- Automatically adds a comma at the end of the provider array element and aliases array in `config/app.php`
- Added a new command to list all facades
- Added a new command to diagnose the facade
- Added new command for usage 

Changes
-------
- Add 'require' in composer.json
- Some changes to the 'php artisan facade' command
- Some changes to the 'php artisan facade:delete' command

0.1.1 - Initial release
-----

Fix
~~~
- fix Composer.json

0.1.0 - First release (Don't use this)
```

# Credits
Thanks to [@rizalio](https://github.com/rizalio) for any help!

# License
MIT License
