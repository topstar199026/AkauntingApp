<?php

namespace Modules\Intercom\Jobs;

use App\Abstracts\Job;
use Http\Client\Exception;
use Illuminate\Support\Facades\Log;
use Intercom\IntercomClient;

class SendMessage extends Job
{
    public $email;

    public $subject;

    public $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $subject, $message)
    {
        $this->email = $email;
        $this->subject = $subject;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('Intercom API Parameters => Token: ' . setting('intercom.token'));
        Log::info('Intercom API Parameters => Admin ID: ' . setting('intercom.admin_id'));
        Log::info('Intercom API Parameters => Enable Inapp: ' . setting('intercom.enable_inapp'));
        Log::info('Intercom API Parameters => Enable Email: ' . setting('intercom.enable_email'));
        
        $client = new IntercomClient(setting('intercom.admin_id'), setting('intercom.token'));

        try {
            if (setting('intercom.enable_inapp', false)) {
                $client->messages->create([
                    "message_type" => "inapp",
                    "body" => $this->message,
                    "from" => [
                        "type" => "admin",
                        "id" => setting('intercom.admin_id'),
                    ],
                    "to" => [
                        "type" => "user",
                        "email" => $this->email,
                    ],
                ]);
            }

            if (setting('intercom.enable_email', false)) {
                $client->messages->create([
                    "message_type" => "email",
                    "subject" => $this->subject,
                    "body" => $this->message,
                    "from" => [
                        "type" => "admin",
                        "id" => setting('intercom.admin_id'),
                    ],
                    "to" => [
                        "type" => "user",
                        "email" => $this->email,
                    ],
                ]);
            }
        } catch (Exception $exception) {
            Log::error('Intercom API Exception: ' . $exception->getResponse()->getBody());
        }
    }
}
