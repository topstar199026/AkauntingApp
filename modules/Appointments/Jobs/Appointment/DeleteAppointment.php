<?php

namespace Modules\Appointments\Jobs\Appointment;

use App\Abstracts\Job;
use Modules\Appointments\Models\Appointment;

class DeleteAppointment extends Job
{
    protected $appointment;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Execute the job.
     *
     * @return Appointment
     */
    public function handle()
    {
        \DB::transaction(function () {
            $this->appointment->delete();
        });

        return true;
    }
}
