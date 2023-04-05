<?php

namespace Modules\Projects\Jobs\Projects;

use App\Abstracts\Job;
use Illuminate\Support\Facades\DB;
use App\Jobs\Document\CreateDocument;
use App\Models\Common\Contact;
use App\Models\Common\Item;
use App\Models\Document\Document;
use App\Models\Setting\Category;
use App\Models\Setting\Currency;
use App\Traits\Documents;
use App\Utilities\Date;
use DateInterval;
use Modules\Projects\Models\Task;

class CreateInvoice extends Job
{
    use Documents;

    protected $model;

    protected $project;

    public function __construct($project)
    {
        $this->project = $project;
    }

    public function handle(): Document
    {
        DB::transaction(function () {
            $contact = Contact::find($this->project->customer_id);
            $now = Date::now();
            $tasks = request('tasks');
            $defaultDate = new Date("00:00");

            $invoiceRequest = [
                'company_id' => company_id(),
                'type' => 'invoice',
                'document_number' => $this->getNextDocumentNumber('invoice'),
                'status' => 'draft',
                'issued_at' => $now,
                'due_at' => $now,
                'currency_code' => setting('default.currency'),
                'currency_rate' => Currency::code(setting('default.currency'))->first()->rate,
                'category_id' => Category::income()->enabled()->first()->id,
                'contact_id' => $this->project->customer_id,
                'contact_name' => $contact->name,
                'contact_email' => $contact->email,
                'contact_tax_number' => $contact->tax_number,
                'contact_phone' => $contact->phone,
                'contact_address' => $contact->address,
                'items' => [],
            ];

            switch (request('project_invoicing_type')) {
                case 'single_line':

                    $notes = '';
                    $totalHoursToDecimal = 0;

                    foreach ($tasks as $key => $value) {
                        if ($value) {
                            $taskDate = new Date("00:00");

                            $task = Task::find($key);

                            $task->timesheets()->each(function ($timesheet) use (&$taskDate, &$totalHoursToDecimal) {
                                date_add($taskDate, date_diff(Date::parse($timesheet->started_at), Date::parse($timesheet->ended_at)));

                                $totalHoursToDecimal += $this->convertHoursToDecimal(date_diff(Date::parse($timesheet->started_at), Date::parse($timesheet->ended_at)));
                            });

                            $notes .= $task->name . ' - ' . $defaultDate->diff($taskDate)->format('%H:%I') . ' ' . trans('projects::general.hours') . "\n";
                        }
                    }

                    $item = Item::firstOrCreate(
                        [
                            'name' => $this->project->name,
                        ],
                        [
                            'company_id' => company_id(),
                            'name' => $this->project->name,
                            'sale_price' => $this->project->billing_rate,
                            'purchase_price' => 0,
                            'description' => $this->project->description,
                        ]
                    );

                    $invoiceItems = [
                        'item_id' => $item->id,
                        'name' => $item->name,
                        'quantity' => 1,
                        'price' => $this->project->billing_rate,
                        'description' => $notes,
                    ];

                    if ($this->project->billing_type == 'projects-hours') {
                        $invoiceItems['quantity'] = $totalHoursToDecimal;
                    }

                    array_push($invoiceRequest['items'], $invoiceItems);

                    break;

                case 'task_per_item':

                    foreach ($tasks as $key => $value) {
                        if ($value) {
                            $totalHoursToDecimal = 0;
                            $taskDate = new Date("00:00");
                            $task = Task::find($key);

                            $task->timesheets()->each(function ($timesheet) use (&$taskDate, &$totalHoursToDecimal) {
                                date_add($taskDate, date_diff(Date::parse($timesheet->started_at), Date::parse($timesheet->ended_at)));

                                $totalHoursToDecimal += $this->convertHoursToDecimal(date_diff(Date::parse($timesheet->started_at), Date::parse($timesheet->ended_at)));
                            });

                            $item = Item::firstOrCreate(
                                [
                                    'name' => $this->project->name . ' - ' . $task->name,
                                ],
                                [
                                    'company_id' => company_id(),
                                    'name' => $this->project->name . ' - ' . $task->name,
                                    'sale_price' => $this->project->billing_rate,
                                    'purchase_price' => 0,
                                    'description' => $this->project->description,
                                ]
                            );

                            $price = $this->project->billing_rate;

                            if ($this->project->billing_type == 'task-hours') {
                                $price = $task->hourly_rate;
                            }

                            array_push($invoiceRequest['items'], [
                                'item_id' => $item->id,
                                'name' => $item->name,
                                'quantity' => $totalHoursToDecimal,
                                'price' => $price,
                                'description' => $defaultDate->diff($taskDate)->format('%H:%I') . ' ' . trans('projects::general.hours'),
                            ]);
                        }
                    }

                    break;
                case 'all_timesheets_individually':

                    foreach ($tasks as $key => $value) {
                        if ($value) {
                            $task = Task::find($key);

                            if (! $task->timesheets->count()) {
                                throw new \Exception(trans('projects::messages.error.timesheet_for_invoice'), 40);
                            }

                            $item = Item::firstOrCreate(
                                [
                                    'name' => $this->project->name . ' - ' . $task->name,
                                ],
                                [
                                    'company_id' => company_id(),
                                    'name' => $this->project->name . ' - ' . $task->name,
                                    'sale_price' => $this->project->billing_rate,
                                    'purchase_price' => 0,
                                    'description' => $this->project->description,
                                ]
                            );

                            $price = $this->project->billing_rate;

                            if ($this->project->billing_type == 'task-hours') {
                                $price = $task->hourly_rate;
                            }

                            $task->timesheets()->each(function ($timesheet) use (&$invoiceRequest, &$item, &$price) {
                                $elapsedTime = date_diff(Date::parse($timesheet->started_at), Date::parse($timesheet->ended_at));

                                $timesheet_note = ! is_null($timesheet->note) ? " - $timesheet->note" : '';

                                array_push($invoiceRequest['items'], [
                                    'item_id' => $item->id,
                                    'name' => $item->name,
                                    'quantity' => $this->convertHoursToDecimal($elapsedTime),
                                    'price' => $price,
                                    'description' => $elapsedTime->format('%H:%I') . ' ' . trans('projects::general.hours') . $timesheet_note,
                                ]);
                            });
                        }
                    }

                    break;
                default:
                    break;
            }

            $this->model = $this->dispatch(new CreateDocument($invoiceRequest));

            foreach ($tasks as $key => $value) {
                $task = Task::find($key);
                if ($value && $task->is_invoiced == false) {
                    $task->update([
                        'status' => 'completed',
                        'is_invoiced' => true,
                        'invoice_id' => $this->model->id,
                    ]);
                }
            }
        });

        return $this->model;
    }

    private function convertHoursToDecimal(DateInterval $dateInterval)
    {
        $minutes = ($dateInterval->h * 60) + $dateInterval->i;

        return round($minutes / 60, 2);
    }
}
