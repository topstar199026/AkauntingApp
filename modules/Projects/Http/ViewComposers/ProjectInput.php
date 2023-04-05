<?php

namespace Modules\Projects\Http\ViewComposers;

use App\Models\Banking\Transaction;
use App\Models\Document\Document;
use App\Traits\Modules;
use Illuminate\View\View;
use Modules\Projects\Models\Project;
use Modules\Projects\Models\Financial;

class ProjectInput
{
    use Modules;

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if ($this->moduleIsDisabled('projects')) {
            return;
        }

        if (!user()->can('read-projects-projects')) {
            return;
        }

        $size = 3;

        $segment_four = request()->segment(4);

        $projects = Project::whereNotIn('status', [1, 2])
            ->pluck('name', 'id');

        switch ($view->getName()) {
            case 'purchases.bills.create':
            case 'purchases.bills.edit':
                $size = 2;

                $selected = $this->getProjectIds($segment_four, Document::class);

                $stack = 'order_number_input_end';

                break;
            case 'banking.transactions.create':
            case 'banking.transactions.edit':
                $transaction_id = request()->segment(4);

                $selected = $this->getProjectIds($segment_four, Transaction::class);

                $stack = 'contact_id_input_end';

                break;
            case 'modals.documents.payment':
                $size = 6;

                $selected = $this->getProjectIds($segment_four, Document::class);

                $stack = 'reference_input_end';

                break;
            case 'sales.invoices.create':
            case 'sales.invoices.edit':
                $size = 2;

                $selected = $this->getProjectIds($segment_four, Document::class);

                $stack = 'order_number_input_end';

                break;
            default:
                $stack = 'order_number_input_end';

                break;
        }

        $view->getFactory()->startPush($stack, view('projects::projects.input', compact('projects', 'selected', 'size')));
    }

    protected function getProjectIds($id, $type)
    {
        return Financial::where([
            'financialable_id' => $id,
            'financialable_type' => $type,
        ])->pluck('project_id')->first();
    }
}
