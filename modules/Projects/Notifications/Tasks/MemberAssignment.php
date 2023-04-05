<?php

namespace Modules\Projects\Notifications\Tasks;

use App\Abstracts\Notification;
use App\Models\Setting\EmailTemplate;

class MemberAssignment extends Notification
{
    public $task;

    public $member;
    
    public $template;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($task = null, $member = null, $template_alias = null)
    {
        parent::__construct();

        $this->task = $task;
        $this->member = $member;
        $this->template = EmailTemplate::alias($template_alias)->first();
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return $this->initMailMessage();
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'template_alias' => $this->template->alias,
        ];
    }

    public function getTags(): array
    {
        return [
            '{task_name}',
            '{task_description}',
            '{task_status}',
            '{task_started_at}',
            '{task_deadline_at}',
            '{task_priority}',
            '{member_name}',
            '{company_name}',
        ];
    }

    public function getTagsReplacement(): array
    {
        return [
            $this->task->name,
            $this->task->description,
            $this->task->status,
            $this->task->started_at,
            $this->task->deadline_at,
            $this->task->priority,
            $this->member->name,
            company()->name,
        ];
    }
}
