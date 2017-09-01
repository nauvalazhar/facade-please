<?php

namespace Nauvalazhar\FacadePlease\Commands;

use Illuminate\Console\Command;
use Artisan;

class FacadePleaseDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'facade:delete {name=null}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Laravel 5 Facade Generator';


    /**
     * Detect os for PATH SEPARATOR Issue
     *
     * @return string
     */

    protected $path;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $this->path = "\\";
        } else {
            $this->path = "/";
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        if($name == 'null') {
            $name = $this->ask('Facade Name (e.g Email, Alert, etc)');
        }

        $path_provider = app_path('Providers' . $this->path . $name . 'FacadeServiceProvider.php');
        $path_facade = app_path(config('facadeplease.namespace') . $this->path);
        $this->info($path_provider);
        if(file_exists($path_provider)) {
            $this->info("\n".$name." is founded! The following files will be deleted:\n");
            $this->info('=> ' . $path_facade . $name . "ClassFacade.php");
            $this->info('=> ' . $path_facade . $name . "Facade.php");
            $this->info('=> ' . $path_provider);
            $confirm = $this->confirm("The command can't be undone and some functions may not work. \nDo you wish to contiune?");
            if($confirm == true) {
                $this->info('Deleting service provider ...');
                unlink($path_provider);
                $this->info('Deleting class facade ...');
                unlink($path_facade . $name . 'ClassFacade.php');
                $this->info('Deleting facade ...');
                unlink($path_facade . $name . 'Facade.php');

                // remote from config
                $this->info('Updating config file ...');
                $config_path = config_path('app.php');
                $app_data = file_get_contents($config_path);
                $remove_config = str_replace("'".$name."' => App" . $this->path . config('facadeplease.namespace') . $this->path . $name . "Facade::class,", "", $app_data);
                $remove_config = str_replace("App" . $this->path . 'Providers' . $this->path . $name . "FacadeServiceProvider::class,", "", $remove_config);
                file_put_contents($config_path, $remove_config);

                $this->info('Dumping the autoloader ...');
                exec('composer dump-autoload -o');
                $this->info('Facade deleted successfully!');
            }
        }else{
            $this->error("\n    Facade doesn't exist!\n");
        }
    }
}
