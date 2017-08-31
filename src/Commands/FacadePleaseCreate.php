<?php

namespace Nauvalazhar\FacadePlease\Commands;

use Illuminate\Console\Command;
use Artisan;

class FacadePleaseCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'facade:please {name?}';

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
        if(!$name) {
            $name = $this->ask('Facade Name (e.g Email, Alert, etc)');
        }

        $class = $name . 'FacadeServiceProvider';
        
        $path_provider = app_path('Providers' . $this->path . $class . '.php');

        // Start
        $this->info("\nGenerating '". $name ."' facade ...\n");
        
        // Checking
        if(file_exists($path_provider)) {
            return $this->error("'" . $name . "' facade already exists!");
        }

        // Generate provider
        $this->info("Generating service provider ...\n");
        Artisan::call('make:provider', [
            'name' => $class
        ]);

        // Binding facade name
        $this->info("Binding facade name into a service provider ...\n");
        $serviceProviderData = file_get_contents($path_provider);

        $serviceProviderRep = str_replace('class ' . $class . ' extends ServiceProvider', 'use App;

class ' . $class . ' extends ServiceProvider' . PHP_EOL, $serviceProviderData);

        $serviceProviderExp = explode("public function register()", $serviceProviderRep);
        $serviceProviderExp1 = str_replace("{", "", $serviceProviderExp[1]);
        $serviceProviderRep =  $serviceProviderExp[0] . 'public function register()
    {
        App::bind("'.strtolower($name).'", function()
        {
            return new \App\\'.config('facadeplease.namespace').'\\'.$name.'ClassFacade;
        });' . $serviceProviderExp1;

        file_put_contents($path_provider, $serviceProviderRep);

        // create facade file
        $this->info("Generating core facade file ...\n");
        if(!is_dir(app_path(config('facadeplease.namespace')))) {
            mkdir(app_path(config('facadeplease.namespace')));
        }
        $facade = fopen(app_path(config('facadeplease.namespace') . $this->path .$name.'Facade.php'), 'w');
        $facadeData = "<?php
namespace App\\".config('facadeplease.namespace').";
use Illuminate\Support\Facades\Facade;
class ".$name."Facade extends Facade {
    protected static function getFacadeAccessor() {
        return '".strtolower($name)."';
    }
}";
        fwrite($facade, $facadeData);
        fclose($facade);


        // create facadeclass file
        $this->info("Generating facade file ...\n");
        $facade = fopen(app_path(config('facadeplease.namespace'). $this->path .$name.'ClassFacade.php'), 'w');
        $facadeData = "<?php
namespace App\\".config('facadeplease.namespace').";

class ".$name."ClassFacade {
    public function hello() {
        return \"Hello, my name is ".$name."!\";
    }
}";
        fwrite($facade, $facadeData);
        fclose($facade);

        // add to config
        $this->info("Registering the facade into the config file ...\n");
        $config = config_path('app.php');
        $configdata = file_get_contents($config);
        $configdata = explode("],", $configdata);
        $alias = $configdata[0] . '
        App\Providers\\'.$class.'::class,
],';
        $facade = $configdata[1] . "    '".$name."' => App\\".config('facadeplease.namespace')."\\".$name."Facade::class,
    ],
];";
        $datatopush = $alias . $facade;
        file_put_contents(config_path('app.php'), $datatopush);
    
        $this->info("\nDumping the Autoloader..\n");
        exec('composer dump-autoload -o');
        
        $this->info("Facade `" . $name . "` generated successfully.\n");
        $this->info("\nUsage:\nuse App\\".config('facadeplease.namespace')."\\".$name.";\n\n" . $name . "::hello();");

        $this->info("\nDone!");
    }
}
