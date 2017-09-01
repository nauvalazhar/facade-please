<?php

namespace Nauvalazhar\FacadePlease\Commands;

use Illuminate\Console\Command;
use Artisan;

class FacadePlease extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'facade {argument?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Laravel 5 Facade Generator';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $arg = $this->argument('argument');
        if(!$arg || $arg == 'about') {
            $this->info("\nWelcome to Laravel 5 Facade Generator!\n
Here you can create your own facade easily, just one command and your facade is ready to use.\n
Usage:
php artisan facade usage

Credits:
=> @nauvalazhar
=> @rizalio\n
Thanks for using this package.
");
        }else if($arg == 'version') {
            $this->info('Version 0.2.0');
        }else if($arg == 'usage') {
            $this->info("
Create | Create a new facade
------
php artisan facade:please MyFacade


Delete | Delete facade
------
php artisan facade:delete MyFacade


List | List all facades
----
php artisan facade:list


Diagnosis | Get facade information
---------
php artisan facade:diag MyFacade [--methods] [--public] [--private]


More info
---------
GitHub: https://github.com/nauvalazhar/facade-please

");
        }else{
            $this->info('Command "' . $arg . '" is undefined!');
            $this->info("\nUsage:
php artisan facade usage\n");
        }
    }
}
