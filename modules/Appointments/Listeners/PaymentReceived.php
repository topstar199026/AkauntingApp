<?php

namespace Modules\Appointments\Listeners;

use App\Events\Document\PaymentReceived as Event;
use App\Traits\Jobs;
use App\Traits\Modules;
use Modules\Appointments\Models\Scheduled;
use Modules\Appointments\Jobs\Scheduled\UpdateScheduled;

class PaymentReceived
{
    use Modules, Jobs;

    /**
     * Handle the event.
     *
     * @param  Event $event
     * @return void
     */
    public function handle(Event $event)
    {
        if (! $this->moduleIsEnabled('appointments')) {
            return;
        }

        if ($event->document->type == 'invoice' && $event->document->status != 'paid') {
            return;
        }

        $scheduled = Scheduled::where('document_id', $event->document->id)->first();

        if ($scheduled) {
            $this->dispatch(new UpdateScheduled($scheduled, request()->merge(['status' => 'approve'])));
        }
    }
}
