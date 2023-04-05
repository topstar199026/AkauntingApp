<?php

namespace Modules\Intercom\Providers;

use App\Events\Document\DocumentRecurring;
use App\Events\Document\DocumentReminded;
use App\Events\Document\DocumentSent;
use App\Events\Document\PaymentReceived;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as Provider;
use Modules\Intercom\Listeners\SendInvoicePaymentNotification;
use Modules\Intercom\Listeners\SendInvoiceRecurringNotification;
use Modules\Intercom\Listeners\SendInvoiceRemindedNotification;
use Modules\Intercom\Listeners\SendInvoiceSentNotification;

class Event extends Provider
{
    /**
     * The event listener mappings for the module.
     *
     * @var array
     */
    protected $listen = [
        DocumentSent::class => [
            SendInvoiceSentNotification::class,
        ],
        DocumentReminded::class => [
            SendInvoiceRemindedNotification::class,
        ],
        DocumentRecurring::class => [
            SendInvoiceRecurringNotification::class,
        ],
        PaymentReceived::class => [
            SendInvoicePaymentNotification::class,
        ],
    ];
}
