<?php

namespace Modules\Helpdesk\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider as Provider;
use Illuminate\Support\Facades\Config;
use App\Models\Auth\User;
use App\Models\Setting\Category;
use Modules\Helpdesk\Models\Status;

class Main extends Provider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->loadConfig();
        $this->loadRoutes();
    }

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViews();
        $this->loadViewComponents();
        $this->loadTranslations();
        $this->loadMigrations();
        $this->loadDynamicRelationships();
    }

    /**
     * Load views.
     *
     * @return void
     */
    public function loadViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'helpdesk');
    }

    /**
     * Load view components.
     *
     * @return void
     */
    public function loadViewComponents()
    {
        Blade::componentNamespace('Modules\Helpdesk\View\Components', 'helpdesk');
    }

    /**
     * Load translations.
     *
     * @return void
     */
    public function loadTranslations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'helpdesk');
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
     * Load config.
     *
     * @return void
     */
    public function loadConfig()
    {
        $merge_to_core_configs = ['search-string', 'type'];
        
        foreach ($merge_to_core_configs as $config) {
            Config::set($config, array_merge_recursive(
                Config::get($config),
                require __DIR__ . '/../Config/' . $config . '.php'
            ));
        }
        
        $this->mergeConfigFrom(__DIR__ . '/../Config/helpdesk.php', 'helpdesk');
    }

    /**
     * Load dynamic relationships.
     *
     * @return void
     */
    public function loadDynamicRelationships()
    {
        // Used for Reports
        User::resolveRelationUsing('helpdesk_tickets_reporter', function ($user) {
            return $user->hasMany('Modules\Helpdesk\Models\Ticket', 'created_by', 'id');
        });
        User::resolveRelationUsing('helpdesk_tickets_assignee', function ($user) {
            return $user->hasMany('Modules\Helpdesk\Models\Ticket', 'assignee_id', 'id');
        });

        // Used for Widgets
        Category::resolveRelationUsing('helpdesk_tickets', function ($category) {
            return $category->hasMany('Modules\Helpdesk\Models\Ticket', 'category_id', 'id');
        });
        Status::resolveRelationUsing('helpdesk_tickets', function ($status) {
            return $status->hasMany('Modules\Helpdesk\Models\Ticket', 'status_id', 'id');
        });

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
            'api.php',
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
