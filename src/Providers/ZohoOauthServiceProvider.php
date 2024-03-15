<?php

namespace Joytekmotion\Zoho\Oauth\Providers;

use Illuminate\Support\ServiceProvider;
use Joytekmotion\Zoho\Oauth\Commands\RefreshTokenCommand;

class ZohoOauthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Publish configuration files
        $this->publishes([
            __DIR__ . '/../config/zoho.php' => config_path('zoho.php'),
        ]);

        // Publish console commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                RefreshTokenCommand::class
            ]);
        }
    }
}
