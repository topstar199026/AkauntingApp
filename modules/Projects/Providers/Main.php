<?php
namespace Modules\Projects\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
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
        $this->loadMigrations();
        $this->loadViewComponents();

        View::composer([
            'sales.invoices.create',
            'sales.invoices.edit',
            'purchases.bills.create',
            'purchases.bills.edit',
            'banking.transactions.create',
            'banking.transactions.edit',
            'modals.documents.payment',
        ], 'Modules\Projects\Http\ViewComposers\ProjectInput');

        // Add limits and bulk actions to index
        View::composer(
            'projects::projects.tasks', 'App\Http\ViewComposers\Index'
        );

        View::composer(
            [
                'components.documents.show.content',
                'components.transactions.show.content',
            ], 'Modules\Projects\Http\ViewComposers\ProjectShow'
        );

        Blade::componentNamespace('Modules\\Projects\\View\\Components', 'projects');
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

    /**
     * Load config.
     *
     * @return void
     */
    public function loadConfig()
    {
        $replaceConfigs = ['custom-fields', 'search-string'];

        foreach ($replaceConfigs as $config) {
            Config::set($config, array_merge_recursive(
                Config::get($config) ?? [],
                require __DIR__ . "/../Config/{$config}.php"
            ));
        }
    }

    /**
     * Load views.
     *
     * @return void
     */
    public function loadViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'projects');
    }

    /**
     * Load view components.
     *
     * @return void
     */
    public function loadViewComponents()
    {
        $components = [
            'overview',
            'tasks',
            'timesheets',
            'milestones',
            'activities',
            'transactions',
            'discussions',
            'attachments',
        ];

        foreach ($components as $component) {
            Blade::component('projects::' . $component, '\Modules\Projects\View\Components\\' . ucfirst($component));
        }
    }

    /**
     * Load translations.
     *
     * @return void
     */
    public function loadTranslations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'projects');
    }

    /**
     * Load migrations.
     *
     * @return void
     */
    public function loadMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
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
            'admin.php',
            'portal.php',
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
