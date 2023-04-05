<?php

namespace Modules\TimeToGetPaid\Providers;

use Illuminate\Support\ServiceProvider as Provider;

class Main extends Provider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslations();
        $this->loadViews();
        $this->loadConfig();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Load views.
     *
     * @return void
     */
    public function loadViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'time-to-get-paid');
    }

    /**
     * Load translations.
     *
     * @return void
     */
    public function loadTranslations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'time-to-get-paid');
    }

    /**
     * Load config.
     *
     * @return void
     */
    public function loadConfig()
    {
        $this->mergeConfigFrom(__DIR__ . '/../Config/config.php', 'time-to-get-paid');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
