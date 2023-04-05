<?php

namespace Modules\Proposals\Notifications;

use App\Abstracts\Notification;
use Illuminate\Support\Facades\URL;

class Proposal extends Notification
{
    /**
     * The proposal model.
     *
     * @var object
     */
    public $proposal;

    /**
     * The estimate model.
     *
     * @var object
     */
    public $document;

    /**
     * The email template.
     *
     * @var string
     */
    public $template;

    /**
     * Create a new notification instance.
     * @param object $proposal
     * @param object $template
     * @return void
     */
    public function __construct($proposal = null, $document = null, $template = null)
    {
        parent::__construct();

        $this->proposal = $proposal;
        $this->document = $document;
        $this->template = $template;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $message = $this->initMailMessage();

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $this->initArrayMessage();

        return [
            'proposal_id' => $this->proposal->id,
        ];
    }

    public function getTags(): array
    {
        return [
            '{proposal_guest_link}',
            '{proposal_portal_link}',
            '{customer_name}',
            '{company_name}',
            '{proposal_description}',
        ];
    }

    public function getTagsReplacement(): array
    {
        if ($this->document instanceof \Modules\Estimates\Models\Estimate) {
            return [
                URL::signedRoute(
                    'signed.proposals.signed',
                    [$this->proposal->id, 'company_id' => $this->proposal->company_id]
                ),
                route('portal.proposals.proposals.show', $this->proposal->id),
                $this->document->contact_name,
                $this->document->company->name,
                $this->proposal->description,
            ];
        }
        elseif ($this->document instanceof \Modules\Crm\Models\Deal) {
            return [
                URL::signedRoute(
                    'signed.proposals.signed',
                    [$this->proposal->id, 'company_id' => $this->proposal->company_id]
                ),
                route('portal.proposals.proposals.show', $this->proposal->id),
                $this->document->contact->contact->name,
                $this->document->company->name,
                $this->proposal->description,
            ];
        }
    }
}
