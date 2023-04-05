<?php

namespace Modules\Appointments\Jobs\Appointment;

use App\Abstracts\Job;
use Modules\Appointments\Models\Appointment;
use Modules\Appointments\Models\Employee;
use Modules\Employees\Models\Employee as BaseEmployee;

class UpdateAppointment extends Job
{
    protected $request;

    protected $appointment;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($appointment, $request)
    {
        $this->appointment = $appointment;
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return Appointment
     */
    public function handle()
    {
        $this->request->merge(['question_ids' => json_encode($this->request->question_ids)]);

        if ($this->request->owner == 'admin') {
            $this->request->merge(['week_days' => json_encode($this->request->week_days)]);
        }

        if ($this->request->appointment_type == 'paid') {
            $this->request->merge(['amount' => $this->request->amount]);
        }

        \DB::transaction(function () {
            $this->appointment->update($this->request->all());

            Employee::where('appointment_id', $this->appointment->id)->delete();

            if ($this->appointment->owner == 'admin') {
                if (isset($this->request->items)) {
                    foreach ($this->request->items as $item) {
                        $employee_id = BaseEmployee::where('contact_id', $item['contact_id'])->value('id');

                        $employee = Employee::create([
                            'company_id'        => $this->request->company_id,
                            'appointment_id'    => $this->appointment->id,
                            'contact_id'        => $item['contact_id'],
                            'employee_id'       => $employee_id,
                            'week_days'         => json_encode($item['week_days']),
                            'starting_time'     => $item['starting_time'],
                            'ending_time'       => $item['ending_time'],
                        ]);
                    }
                }
            }
        });

        return $this->appointment;
    }
}
