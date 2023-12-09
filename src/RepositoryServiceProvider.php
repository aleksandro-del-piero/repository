<?php
namespace AleksandroDelPiero\Repository;

use AleksandroDelPiero\Repository\Commands\MakeRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeRepository::class
            ]);
        }

        $this->publishes([
            __DIR__.'/../config/repository.php' => config_path('repository.php'),
        ]);
    }
}
