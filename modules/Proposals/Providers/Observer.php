<?php
namespace Modules\Proposals\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Crm\Models\Deal;
use Modules\Crm\Models\DealPipeline;

class Observer extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        if (module('crm')) {
            DealPipeline::observe('Modules\Proposals\Observers\Pipeline');
            Deal::observe('Modules\Proposals\Observers\Deal');
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
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
