<?php

namespace Nauvalazhar\FacadePlease\Commands;

use Illuminate\Console\Command;
use Artisan;

class FacadePleaseDiag extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'facade:diag {name} {--methods} {--private} {--public}';

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
        $m_option = $this->option('methods');
        $pr_option = $this->option('private');
        $pb_option = $this->option('public');
        $name = $this->argument('name');
        $path = app_path(config('facadeplease.namespace') . $this->path . $name . 'ClassFacade.php');
        if(!file_exists($path)) {
            $this->error("\n    Whoopps! Facade couldn't be found, sorry.\n");
            $this->info("\n    Suggest:\n");
            $this->info("    'php artisan facade:list' to see the list of facades\n\n");
            exit();
        }
        $get_content = file_get_contents($path);
        $get_content = trim($get_content);
        $class = new \ReflectionClass("App\\" . config("facadeplease.namespace") . "\\" . $name . "ClassFacade");
        $methods = $class->getMethods(\ReflectionMethod::IS_PUBLIC);
        $private = $class->getMethods(\ReflectionMethod::IS_PRIVATE);
        $_m = "";
        if(!$m_option) {        
            $this->info("\n" . $name . ' Facade Diagnosis:');
            $this->info("");
            $this->info('Facade Name     : ' . $name);
            $this->info('Class Name      : ' . $name . "ClassFacade");
            $this->info('Path            : ' . $path);
            $this->info('Public Methods  : ' . count($methods));
            $this->info('Private Methods : ' . count($private));
        }
        if((!$pb_option && !$pr_option) || ($pb_option && !$pr_option) || ($pb_option && $pr_option)) {
            $this->info("\nPublic Methods:\n");
            foreach($methods as $item) {
                $_m .= "=> " . $item->name . "\n";
            }            
        }
        $this->info($_m);
        $_p = "";
        if((!$pb_option && !$pr_option) || (!$pb_option && $pr_option) || ($pb_option && $pr_option)) {
            $this->info("Private Methods:\n");
            foreach($private as $item1) {
                $_p .= "=> " . $item1->name . "\n";
            }
        }

        $this->info($_p);
    }
}
