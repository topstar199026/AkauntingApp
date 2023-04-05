<?php

namespace Modules\Helpdesk\Providers;

use Illuminate\Support\ServiceProvider as Provider;
use Modules\Helpdesk\Models\Ticket;
use Modules\Helpdesk\Models\Reply;

class Observer extends Provider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        Ticket::observe('Modules\Helpdesk\Observers\Ticket');

        Reply::observe('Modules\Helpdesk\Observers\Reply');
    }
}
