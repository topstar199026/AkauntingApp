<?php

namespace Modules\Projects\Widgets;

use App\Abstracts\Widget;
use App\Models\Banking\Transaction;
use Modules\Projects\Models\Financial;

class TotalRevenue extends Widget
{

    public $default_name = 'projects::general.widgets.total_revenue';

    public function getDefaultSettings()
    {
        return [
            'width' => 'w-1/2 sm:w-1/3 text-center',
        ];
    }

    public function show($project = null)
    {
        $revenueTotal = 0;
        $revenueTotalAmount = 0;

        if ($project) {
            $hasProject = true;
            $ids = $project->financials()->type(Transaction::class)->pluck('financialable_id');
            $this->views['header'] = 'projects::widgets.standard_header';
        } else {
            $hasProject = false;
            $ids = Financial::type(Transaction::class)->pluck('financialable_id');
            $this->views['header'] = 'projects::widgets.stats_header';
        }

        $revenueTotal = $this->applyFilters(Transaction::whereIn('id', $ids)->type('income')->isNotDocument())
            ->get()
            ->count();

        $this->applyFilters(Transaction::whereIn('id', $ids)->type('income')->isNotDocument())
            ->get()
            ->each(function ($item, $key) use (&$revenueTotalAmount) {
            $revenueTotalAmount += $item->getAmountConvertedToDefault();
        });

        return $this->view('projects::widgets.total_revenue', [
            'revenueTotal' => $revenueTotal,
            'revenueTotalAmount' => money($revenueTotalAmount, setting('default.currency'), true)->formatForHumans(),
            'hasProject' => $hasProject,
        ]);
    }
}
