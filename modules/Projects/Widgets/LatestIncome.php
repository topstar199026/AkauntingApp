<?php

namespace Modules\Projects\Widgets;

use App\Abstracts\Widget;
use App\Models\Banking\Transaction;
use Illuminate\Support\Facades\Route;
use Modules\Projects\Models\Financial;

class LatestIncome extends Widget
{
    public $default_name = 'projects::general.widgets.latest_income_by_project';

    public $default_settings = [
        'width' => 'w-full lg:w-1/3 px-12 my-8',
    ];

    public function show($project = null)
    {
        if ($project) {
            $this->model->name = trans('projects::general.widgets.latest_income');

            $ids = $project->financials()->type(Transaction::class)->pluck('financialable_id');
        } else {
            $ids = Financial::type(Transaction::class)->pluck('financialable_id');
        }

        $model = Transaction::with('category')->type('income')
            ->whereIn('id', $ids)
            ->orderBy('paid_at', 'desc')
            ->isNotTransfer()
            ->isNotDocument()
            ->take(5);

        $transactions = $this->applyFilters($model)
            ->get();

        if (Route::is('projects.projects.show')) {
            $this->views = ['header' => 'projects::widgets.empty_header'];
        }

        return $this->view('projects::widgets.latest_income', [
            'transactions' => $transactions,
        ]);
    }
}
