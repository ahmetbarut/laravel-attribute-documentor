<?php

namespace AhmetBarut\Documentor\Providers;

use Illuminate\Support\ServiceProvider;

class AhmetBarutLaravelDocumentorProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \AhmetBarut\Documentor\Commands\GenerateDocumentCommand::class,
            ]);
        }
    }
}
