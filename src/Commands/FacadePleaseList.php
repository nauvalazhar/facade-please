<?php

namespace Nauvalazhar\FacadePlease\Commands;

use Illuminate\Console\Command;
use Artisan;

class FacadePleaseList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'facade:list';

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
        $path = app_path(config('facadeplease.namespace'));
        $files = scandir($path);
        $files = array_diff(scandir($path), array('.', '..'));
        $_f = "";
        $this->info("\nFacade contained in the 'app/".config('facadeplease.namespace')."' folder:");
        foreach($files as $item) {
            if(strpos($item, "Class")) {
                $_f .= "=> " . str_replace("ClassFacade.php", "", $item) ."\n";            
            }
        }
        $this->info($_f);
        $this->info("[NOTE] To see all facade methods, you can use the command 'php artisan facade:diag FacadeName'\n");
    }
}
