<?php
namespace Modules\Mt940\Providers;

use Illuminate\Support\ServiceProvider as Provider;
use Modules\Mt940\Listeners\ShowAdminMenu;
use Modules\Mt940\Listeners\ModuleInstalled;

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
        $this->loadEvents();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->loadRoutes();
        $this->loadConfig();
    }

    public function loadEvents()
    {
        $this->app['events']->listen(\App\Events\Menu\AdminCreated::class, ShowAdminMenu::class);
        $this->app['events']->listen(\App\Events\Module\Installed::class, ModuleInstalled::class);
    }

    /**
     * Load views.
     *
     * @return void
     */
    public function loadViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'mt940');
    }

    /**
     * Load translations.
     *
     * @return void
     */
    public function loadTranslations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'mt940');
    }

    /**
     * Load config.
     *
     * @return void
     */
    public function loadConfig()
    {
        config(['mediable' => array_merge_recursive(
            config('mediable') ,
            require __DIR__ . '/../Config/mediable.php'
        )]);
    }

    /**
     * Load routes.
     *
     * @return void
     */
    public function loadRoutes()
    {
        if (app()->routesAreCached()) {
            return;
        }

        $routes = [
            'admin.php'
        ];

        foreach ($routes as $route) {
            $this->loadRoutesFrom(__DIR__ . '/../Routes/' . $route);
        }
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
