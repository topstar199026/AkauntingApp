<?php

namespace Modules\Helpdesk\Notifications;

use App\Abstracts\Notification;
use App\Models\Setting\EmailTemplate;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Helpdesk\Models\Ticket as Model;

class Ticket extends Notification
{
    /**
     * The ticket model.
     *
     * @var Model
     */
    public $ticket;

    /**
     * The email template.
     *
     * @var EmailTemplate
     */
    public $template;

    public function __construct($ticket = null, $template_alias = null)
    {
        parent::__construct();

        $this->ticket = $ticket;
        $this->template = EmailTemplate::alias($template_alias)->first();
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $message = $this->initMessage();

        return $message;
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        $this->initArrayMessage();

        return [
            'template_alias' => $this->template->alias,
            'ticket_name' => $this->ticket->name,
            'ticket_subject' => $this->ticket->subject,
            'ticket_reporter' => $this->ticket->owner->name,
            'ticket_message' => $this->ticket->message,
            'ticket_status' => $this->ticket->statuses[$this->ticket->status_id],
        ];
    }

    public function getTags(): array
    {
        return [
            '{ticket_name}',
            '{ticket_subject}',
            '{ticket_reporter}',
            '{ticket_message}',
            '{ticket_status}',
            '{company_name}',
        ];
    }

    public function getTagsReplacement(): array
    {
        return [
            $this->ticket->name,
            $this->ticket->subject,
            $this->ticket->owner->name,
            $this->ticket->message,
            $this->ticket->statuses[$this->ticket->status_id],
            $this->ticket->company->name,
        ];
    }
}
