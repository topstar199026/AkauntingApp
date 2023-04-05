<?php

namespace Modules\Projects\Listeners\Update;

use App\Abstracts\Listeners\Update as Listener;
use App\Events\Install\UpdateFinished;
use App\Models\Banking\Transaction;
use App\Models\Document\Document;
use Illuminate\Support\Facades\DB;
use Modules\Projects\Models\Financial;
use Modules\Projects\Models\ProjectBill;
use Modules\Projects\Models\ProjectInvoice;
use Modules\Projects\Models\ProjectPayment;
use Modules\Projects\Models\ProjectRevenue;

class Version402 extends Listener
{
    const ALIAS = 'projects';

    const VERSION = '4.0.2';

    /**
     * Handle the event.
     *
     * @param  $event
     * @return void
     */
    public function handle(UpdateFinished $event)
    {
        if ($this->skipThisUpdate($event)) {
            return;
        }

        $this->updateFinancials();
    }

    protected function updateFinancials()
    {
        DB::transaction(function () {
            Financial::allCompanies()->get()->each(function ($financial) {
                $financial->forceDelete();
            });

            ProjectInvoice::allCompanies()->get()
                ->each(function ($project_invoice) {
                    Financial::create([
                        'company_id' => $project_invoice->company_id,
                        'project_id' => $project_invoice->project_id,
                        'financialable_id' => $project_invoice->invoice_id,
                        'financialable_type' => Document::class,
                    ]);
                });

            ProjectBill::allCompanies()->get()
                ->each(function ($project_bill) {
                    Financial::create([
                        'company_id' => $project_bill->company_id,
                        'project_id' => $project_bill->project_id,
                        'financialable_id' => $project_bill->bill_id,
                        'financialable_type' => Document::class,
                    ]);
                });

            ProjectRevenue::allCompanies()->get()
                ->each(function ($project_revenue) {
                    Financial::create([
                        'company_id' => $project_revenue->company_id,
                        'project_id' => $project_revenue->project_id,
                        'financialable_id' => $project_revenue->revenue_id,
                        'financialable_type' => Transaction::class,
                    ]);
                });

            ProjectPayment::allCompanies()->get()
                ->each(function ($project_payment) {
                    Financial::create([
                        'company_id' => $project_payment->company_id,
                        'project_id' => $project_payment->project_id,
                        'financialable_id' => $project_payment->payment_id,
                        'financialable_type' => Transaction::class,
                    ]);
                });

        });
    }
}
