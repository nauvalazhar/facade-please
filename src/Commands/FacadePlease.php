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
    protected $signature = 'facade {mode}';

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
        $mode = $this->argument('mode');
        if($mode == 'about') {
            $this->info("\nWelcome to Laravel 5 Facade Generator!\n
Here you can create your own facade easily, just one command and your facade is ready to use.\n
Usage:
Create => php artisan facade:please MyFacade
Delete => php artisan facade:delete MyFacade

Credits:
=> @nauvalazhar
=> @rizalio\n
Thanks for using this package.
");
        }else if($mode == 'version') {
            $this->info('Version 0.1.0');
        }else{
            $this->info('Command "' . $mode . '" is undefined!');
            $this->info("\nUsage:
Create => php artisan facade:please MyFacade
Delete => php artisan facade:delete MyFacade");
        }
    }
}
