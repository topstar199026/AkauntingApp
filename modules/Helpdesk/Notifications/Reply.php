<?php

namespace Modules\Helpdesk\Notifications;

use App\Abstracts\Notification;
use App\Models\Setting\EmailTemplate;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Helpdesk\Models\Reply as Model;

class Reply extends Notification
{
    /**
     * The reply model.
     *
     * @var Model
     */
    public $reply;

    /**
     * The email template.
     *
     * @var EmailTemplate
     */
    public $template;

    public function __construct($reply = null, $template_alias = null)
    {
        parent::__construct();

        $this->reply = $reply;

        $this->template = EmailTemplate::alias($template_alias)->first();
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $message = $this->initMailMessage();

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
            'title' => trans('helpdesk::notifications.menu.' . $this->template->alias . '.title'),
            'description' => trans('helpdesk::notifications.menu.' . $this->template->alias . '.description', $this->getTagsBinding()),
            'reply_author' => $this->reply->owner->name,
            'reply_message' => $this->reply->message,
            'ticket_name' => $this->reply->ticket->name,
            'ticket_reporter' => $this->reply->ticket->owner->name,
            'ticket_subject' => $this->reply->ticket->subject,
        ];
    }

    public function getTags(): array
    {
        return [
            '{reply_author}',
            '{reply_message}',
            '{company_name}',
            '{ticket_name}',
            '{ticket_reporter}',
            '{ticket_subject}',
            '{ticket_admin_link}',
        ];
    }

    public function getTagsReplacement(): array
    {
        return [
            $this->reply->owner->name,
            $this->reply->message,
            $this->reply->company->name,
            $this->reply->ticket->name,
            $this->reply->ticket->owner->name,
            $this->reply->ticket->subject,
            route('helpdesk.tickets.show', $this->reply->ticket->id),
        ];
    }
}
