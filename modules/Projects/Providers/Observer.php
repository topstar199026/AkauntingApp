<?php

namespace Modules\Projects\Providers;

use App\Models\Auth\User;
use App\Models\Banking\Transaction;
use App\Models\Document\Document;
use Illuminate\Support\ServiceProvider;
use Modules\Projects\Models\Comment;
use Modules\Projects\Models\Discussion;
use Modules\Projects\Models\Milestone;
use Modules\Projects\Models\Project;
use Modules\Projects\Models\Task;

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
        Document::observe('Modules\Projects\Observers\Document');
        Transaction::observe('Modules\Projects\Observers\Transaction');
        User::observe('Modules\Projects\Observers\User');

        Project::observe('Modules\Projects\Observers\Project');
        Comment::observe('Modules\Projects\Observers\Comment');
        Discussion::observe('Modules\Projects\Observers\Discussion');
        Milestone::observe('Modules\Projects\Observers\Milestone');
        Task::observe('Modules\Projects\Observers\Task');
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
