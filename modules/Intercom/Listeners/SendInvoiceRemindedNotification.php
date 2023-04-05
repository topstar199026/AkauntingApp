<?php

namespace Modules\Intercom\Listeners;

use App\Events\Document\DocumentReminded as Event;
use App\Models\Setting\EmailTemplate;
use App\Models\Document\Document;
use App\Notifications\Sale\Invoice as Notification;
use App\Traits\Jobs;
use Modules\Intercom\Jobs\SendMessage;

class SendInvoiceRemindedNotification
{
    use Jobs;

    /**
     * Handle the event.
     *
     * @param  $event
     * @return void
     */
    public function handle(Event $event)
    {
        if (empty(setting('intercom.token'))) {
            return;
        }

        // Check contact info and the document type
        if (!$event->document->contact || $event->document->type != Document::INVOICE_TYPE) {
            return;
        }

        // Notify the customer
        $notification = new Notification($event->document, 'invoice_remind_customer');
        $template = EmailTemplate::alias('invoice_remind_customer')->first();
        $message = $notification->getBody($template);
        $subject = $notification->getSubject($template);

        // Check message
        if (empty($message)) {
            return;
        }

        // Convert message
        $message = str_replace("<br />", "\n", $message);
        $message = str_replace("<br/>", "\n", $message);
        $message_array = preg_split('/<a[\s]+([^>]+)>((?:.(?!\<\/a\>))*.)<\/a>/', $message);
        preg_match('/<a[^>]+href=\"(.*?)\"[^>]*>(.*?)<\/a>/', $message, $link);
        $message = $message_array[0] . $link[1] . $message_array[1];
        $message = trim(strip_tags($message));

        $this->dispatch(new SendMessage($event->document->contact->email, $subject, $message));
    }
}
