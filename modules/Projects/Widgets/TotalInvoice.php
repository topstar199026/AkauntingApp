<?php

namespace Modules\Projects\Widgets;

use App\Abstracts\Widget;
use App\Models\Document\Document;
use Modules\Projects\Models\Financial;

class TotalInvoice extends Widget
{
    public $default_name = 'projects::general.widgets.total_invoice';

    public function getDefaultSettings()
    {
        return [
            'width' => 'w-1/2 sm:w-1/3 text-center',
        ];
    }

    public function show($project = null)
    {
        $invoiceTotal = 0;
        $invoiceTotalAmount = 0;

        if ($project) {
            $hasProject = true;
            $ids = $project->financials()->type(Document::class)->pluck('financialable_id');
            $this->views['header'] = 'projects::widgets.standard_header';
        } else {
            $hasProject = false;
            $ids = Financial::type(Document::class)->pluck('financialable_id');
            $this->views['header'] = 'projects::widgets.stats_header';
        }

        $invoiceTotal = $this->applyFilters(Document::whereIn('id', $ids)->invoice()->accrued(), ['date_field' => 'issued_at'])
            ->get()
            ->count();

        $this->applyFilters(Document::whereIn('id', $ids)->invoice()->accrued(), ['date_field' => 'issued_at'])
            ->get()
            ->each(function ($item, $key) use (&$invoiceTotalAmount) {
                $invoiceTotalAmount += $item->getAmountConvertedToDefault();
            });

        return $this->view('projects::widgets.total_invoice', [
            'invoiceTotal' => $invoiceTotal,
            'invoiceTotalAmount' => money($invoiceTotalAmount, setting('default.currency'), true)->formatForHumans(),
            'hasProject' => $hasProject,
        ]);
    }
}
