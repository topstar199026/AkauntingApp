<?php

namespace Modules\Appointments\Jobs\Scheduled;

use App\Abstracts\Job;
use App\Models\Common\Contact;
use App\Models\Setting\Category;
use App\Models\Setting\Currency;
use App\Models\Document\Document;
use App\Jobs\Document\CreateDocument as BaseCreateDocument;
use App\Http\Requests\Document\Document as Request;
use App\Traits\Documents;
use Modules\Employees\Models\Employee;
use Modules\Appointments\Models\Scheduled;
use Modules\Appointments\Models\Appointment;
use Modules\Appointments\Notifications\Appointment as Notification;
use Date;

class CreateScheduled extends Job
{
    use Documents;

    protected $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return Appointment
     */
    public function handle()
    {
        if (isset($this->request->question_answer)) {
            $this->request->question_answer = json_encode($this->request->question_answer);
        }

        $appointment = Appointment::find($this->request->appointment_id);

        if ($appointment->owner == 'employee') {
            $employee = Employee::where('id', $this->request->employee_id)->first();
        }

        $contact = Contact::firstOrCreate([
            'name'          => $this->request->name,
        ], [
            'company_id'    => company_id(),
            'currency_code' => setting('default.currency'),
            'enabled'       => true,
            'type'          => 'customer',
        ]);


        $this->request->merge(['contact_id' => $contact->id]);

        if ($appointment->approval_control == true) {
            $this->request->merge(['status' => 'waiting']);
        } else {
            if ($appointment->appointment_type == 'paid') {
                $currency = Currency::where('code', setting('default.currency'))->first();
                $date = Date::now()->toDateTimeString();
                $amount = str_replace(",", "", $appointment->amount);

                $items =[[
                    'name' => $appointment->name,
                    'price' => $amount,
                    'quantity' => 1,
                    'currency' => $currency->code,
                    'description' => '',
                ]];

                $invoice_data =  [
                    'company_id' => company_id(),
                    'contact_id' => $contact->id,
                    'issued_at' => $date,
                    'due_at' => $this->request->date,
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

                $this->request->merge(['status' => 'send']);
            } else {
                $this->request->merge(['status' => 'approve']);
            }
        }

        \DB::transaction(function () use ($appointment){
            $this->request->merge(['company_id' => company_id()]);

            $this->scheduled = Scheduled::create($this->request->all());

            $appointment->contact_name = $this->request->name;
            $customer = [
                'name' => $this->request->name,
                'email' => $this->request->email,
                'phone' => $this->request->phone,
                'date' => $this->request->date,
                'starting_time' => $this->request->starting_time,
            ];

            // if ($this->request->status == 'waiting') {
            //     $this->scheduled->notify(new Notification($appointment, 'appointment_new_request_customer', $customer));
            //     user()->notify(new Notification($appointment, 'appointment_new_request_admin', $customer));
            // } else if ($this->request->status == 'approve') {
            //     $this->scheduled->notify(new Notification($appointment, 'appointment_detail_customer', $customer));
            // } else if ($this->request->status == 'sent') {
            //     $this->scheduled->notify(new Notification($appointment, 'appointment_paid_request_customer', $customer));
            // }
        });

        return $this->scheduled;
    }
}
