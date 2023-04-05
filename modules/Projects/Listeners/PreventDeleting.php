<?php

namespace Modules\Projects\Listeners;

use App\Events\Common\RelationshipCounting as Event;
use App\Models\Common\Contact;

class PreventDeleting
{
    public function handle(Event $event)
    {
        if (! $event->record->model instanceof Contact) {
            return;
        }

        $event->record->relationships['projects'] = 'projects::general.projects';
    }
}
