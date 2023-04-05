<?php

namespace Modules\Appointments\Notifications;

use App\Abstracts\Notification;
use App\Models\Setting\EmailTemplate;
use App\Traits\Documents;
use Illuminate\Support\Facades\URL;
use Modules\Appointments\Models\Appointment as Model;
use Illuminate\Notifications\Messages\MailMessage;

class Appointment extends Notification
{
    use Documents;

    /**
     * The appointment model.
     *
     * @var Model
     */
    public $appointment;

    /**
     * The email template.
     *
     * @var string
     */
    public $template;

    /**
     * The email template.
     *
     * @var array
     */
    public $customer;

    /**
     * The email template.
     *
     * @var array
     */
    public $document;

    public function __construct(Model $appointment = null, string $template_alias = null, $customer = null, $document = null)
    {
        parent::__construct();

        $this->appointment  = $appointment;
        $this->customer     = $customer;
        $this->document     = $document;
        $this->template     = EmailTemplate::alias($template_alias)->first();
    }

        /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $message = (new MailMessage)
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject($this->getSubject())
            ->view('partials.email.body', ['body' => $this->getBody()]);

        return $message;
    }

    public function getTags()
    {
        return [
            '{appointment_name}',
            '{appointment_duration}.',
            '{appointment_time}',
            '{appointment_date}',
            '{customer_name}',
            '{company_name}',
            '{invoice_guest_link}',
            '{invoice_number}',
        ];
    }

    public function getTagsReplacement()
    {
        return [
            $this->appointment->appointment_name,
            $this->appointment->appointment_duration,
            $this->customer['starting_time'],
            $this->customer['date'],
            $this->customer['name'],
            $this->appointment->company->name,
            URL::signedRoute('signed.invoices.show', [isset($this->customer['document_id']) ? $this->customer['document_id'] : '']),
            isset($this->customer['document_id']) ? $this->customer['document_id'] : '',
        ];
    }
}
