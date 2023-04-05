<?php

namespace Modules\Appointments\Jobs\Scheduled;

use Date;
use App\Abstracts\Job;
use App\Traits\Documents;
use App\Models\Common\Contact;
use App\Models\Setting\Category;
use App\Models\Setting\Currency;
use App\Models\Document\Document;
use Illuminate\Support\Facades\DB;
use Modules\Appointments\Models\Scheduled;
use Modules\Appointments\Models\Appointment;
use App\Http\Requests\Document\Document as Request;
use App\Jobs\Document\CreateDocument as BaseCreateDocument;
use Modules\Appointments\Notifications\Appointment as Notification;

class UpdateScheduled extends Job
{
    use Documents;

    protected $request;

    protected $scheduled;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($scheduled, $request)
    {
        $this->scheduled = $scheduled;
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return Scheduled
     */
    public function handle()
    {
        \DB::transaction(function () {
            $appointment = Appointment::find($this->scheduled->appointment_id);

            if ($this->request->status == 'sent') {
                $contact = Contact::where('id',  $this->scheduled->contact_id)->first();
                $currency = Currency::where('code', setting('default.currency'))->first();

                $issued_at = Date::now()->toDateTimeString();
                $due_at = Date::parse($this->scheduled->date)->toDateTimeString();

                $amount = str_replace(",", "", $appointment->amount);

                $items =[[
                    'name' => $appointment->appointment_name,
                    'price' => $amount,
                    'quantity' => 1,
                    'currency' => $currency->code,
                    'description' => '',
                ]];

                $invoice_data =  [
                    'company_id' => company_id(),
                    'contact_id' => $contact->id,
                    'issued_at' => $issued_at,
                    'due_at' => $due_at,
                    'type' => Document::INVOICE_TYPE,
                    'document_number' => $this->getNextDocumentNumber(Document::INVOICE_TYPE),
                    'items' => $items,
                    'currency_code' => $currency->code,
                    'currency_rate' => $currency->rate,
                    'category_id' => Category::income()->pluck('id')->first(),
                    'contact_name' =>  $contact->name,
                    'contact_email' => $contact->email,
                    'contact_tax_number' => $contact->tax_number,
                    'contact_phone' =>  $contact->phone,
                    'contact_address' =>  $contact->address,
                    'status' => 'draft',
                ];

                $invoice_request = new Request();
                $invoice_request->merge($invoice_data);

                $invoice = $this->dispatch(new BaseCreateDocument($invoice_data));

                event(new \App\Events\Document\DocumentSent($invoice));

                $this->scheduled->update([
                    'document_id'   => $invoice->id,
                    'status'        => $this->request->status,
                ]);

                $customer = [
                    'name' => $this->scheduled->name,
                    'email' => $this->scheduled->email,
                    'phone' => $this->scheduled->phone,
                    'date' => $this->scheduled->date,
                    'starting_time' => $this->scheduled->starting_time,
                    'document_id' => $this->scheduled->document_id,
                ];

                $this->scheduled->notify(new Notification($appointment, 'appointment_paid_request_customer', $customer));
            } else {
                $this->scheduled->update([
                    'status' => $this->request->status,
                ]);

                $customer = [
                    'name' => $this->scheduled->name,
                    'email' => $this->scheduled->email,
                    'phone' => $this->scheduled->phone,
                    'date' => $this->scheduled->date,
                    'starting_time' => $this->scheduled->starting_time,
                ];

                if ($this->request->status == 'approve') {
                    $this->scheduled->notify(new Notification($appointment, 'appointment_detail_customer', $customer));
                }
            }
        });

        return $this->scheduled;
    }
}
