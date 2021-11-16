<?php

namespace EmailDomain;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/email-domain.php' => config_path('email-domain.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../storage/email-domain' => config('email-domain.storage_path'),
            ], 'storage');

            $this->commands([
                //
            ]);
        }

        $this->app->bind('email-domain-checker', function () {
            return new EmailDomainChecker();
        });
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/email-domain.php', 'email-domain');
    }
}
