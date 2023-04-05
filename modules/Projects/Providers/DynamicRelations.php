<?php

namespace Modules\Projects\Providers;

use App\Models\Banking\Transaction;
use App\Models\Common\Contact;
use App\Models\Document\Document;
use Illuminate\Support\ServiceProvider;
use Modules\Projects\Models\Financial;
use Modules\Projects\Models\Project;

class DynamicRelations extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Contact::resolveRelationUsing('projects', function ($contact) {
            return $contact->hasMany(Project::class, 'customer_id', 'id');
        });

        Document::resolveRelationUsing('project', function ($document) {
            return $document->hasOne(Financial::class, 'financialable_id', 'id')->where('financialable_type', Document::class);
        });

        Transaction::resolveRelationUsing('project', function ($transaction) {
            return $transaction->hasOne(Financial::class, 'financialable_id', 'id')->where('financialable_type', Document::class);
        });
    }

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
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
