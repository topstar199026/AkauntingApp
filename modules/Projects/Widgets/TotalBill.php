<?php

namespace Modules\Projects\Widgets;

use App\Abstracts\Widget;
use App\Models\Document\Document;
use Modules\Projects\Models\Financial;

class TotalBill extends Widget
{
    public $default_name = 'projects::general.widgets.total_bill';

    public function getDefaultSettings()
    {
        return [
            'width' => 'w-1/2 sm:w-1/3 text-center',
        ];
    }

    public function show($project = null)
    {
        $billTotal = 0;
        $billTotalAmount = 0;

        if ($project) {
            $hasProject = true;
            $ids = $project->financials()->type(Document::class)->pluck('financialable_id');
            $this->views['header'] = 'projects::widgets.standard_header';
        } else {
            $hasProject = false;
            $ids = Financial::type(Document::class)->pluck('financialable_id');
            $this->views['header'] = 'projects::widgets.stats_header';
        }

        $billTotal = $this->applyFilters(Document::whereIn('id', $ids)->bill()->accrued(), ['date_field' => 'issued_at'])
            ->get()
            ->count();

        $this->applyFilters(Document::whereIn('id', $ids)->bill()->accrued(), ['date_field' => 'issued_at'])
            ->get()
            ->each(function ($item, $key) use (&$billTotalAmount) {
                $billTotalAmount += $item->getAmountConvertedToDefault();
            });

        return $this->view('projects::widgets.total_bill', [
            'billTotal' => $billTotal,
            'billTotalAmount' => money($billTotalAmount, setting('default.currency'), true)->formatForHumans(),
            'hasProject' => $hasProject,
        ]);
    }
}
