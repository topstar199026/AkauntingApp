<?php

namespace Modules\Appointments\Database\Seeds;

use App\Abstracts\Model;
use App\Models\Setting\EmailTemplate;
use Illuminate\Database\Seeder;
use Modules\Appointments\Notifications\Appointment;

class EmailTemplates extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->create();

        Model::reguard();
    }

    private function create()
    {
        $company_id = $this->command->argument('company');

        $templates = [
            [
                'alias' => 'appointment_new_request_admin',
                'class' => Appointment::class,
                'name'  => 'appointments::settings.appointment.new_request_admin',
            ],
            [
                'alias' => 'appointment_remind_admin',
                'class' => Appointment::class,
                'name'  => 'appointments::settings.appointment.remind_admin',
            ],
            [
                'alias' => 'appointment_new_request_customer',
                'class' => Appointment::class,
                'name'  => 'appointments::settings.appointment.new_request_customer',
            ],
            [
                'alias' => 'appointment_paid_request_customer',
                'class' => Appointment::class,
                'name'  => 'appointments::settings.appointment.paid_request_customer',
            ],
            [
                'alias' => 'appointment_detail_customer',
                'class' => Appointment::class,
                'name'  => 'appointments::settings.appointment.detail_customer',
            ],
            [
                'alias' => 'appointment_remind_customer',
                'class' => Appointment::class,
                'name'  => 'appointments::settings.appointment.remind_customer',
            ],
            [
                'alias' => 'appointment_remind_employee',
                'class' => Appointment::class,
                'name'  => 'appointments::settings.appointment.remind_employee',
            ],
        ];

        foreach ($templates as $template) {
            EmailTemplate::create(
                [
                    'company_id' => $company_id,
                    'alias'      => $template['alias'],
                    'class'      => $template['class'],
                    'name'       => $template['name'],
                    'subject'    => trans('appointments::email_templates.' . $template['alias'] . '.subject'),
                    'body'       => trans('appointments::email_templates.' . $template['alias'] . '.body'),
                ]
            );
        }
    }
}
