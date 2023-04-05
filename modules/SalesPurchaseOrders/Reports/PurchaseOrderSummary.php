<?php

namespace Modules\SalesPurchaseOrders\Reports;

use App\Abstracts\Report;
use Modules\SalesPurchaseOrders\Models\PurchaseOrder\Model;

class PurchaseOrderSummary extends Report
{
    public $default_name = 'sales-purchase-orders::purchase_orders.summary_report_type';

    public $icon = 'check';

    public $type = 'summary';

    public $chart = [
        'bar' => [
            'colors' => [
                '#fb7185',
            ],
        ],
        'donut' => [
            //
        ],
    ];

    public function setData()
    {
        //@TODO change here with the new daily update commit
        switch ($this->getSearchStringValue('basis', $this->getSetting('basis'))) {
            case 'billed':
                $this->setTotals(Model::purchase()->billed()->get(), 'issued_at');

                break;
            default:
                $documents = $this->applyFilters(Model::purchase()->accrued(), ['date_field' => 'issued_at'])->get();
                $this->setTotals($documents, 'issued_at');
                break;
        }
    }

    public function getBasisField()
    {
        return [
            'type' => 'selectGroup',
            'name' => 'basis',
            'title' => trans('general.basis'),
            'icon' => 'file',
            'values' => [
                'accrual' => trans('general.accrual'),
                'billed' => trans('sales-purchase-orders::purchase_orders.statuses.billed'),
            ],
            'selected' => 'accrual',
            'attributes' => [
                'required' => 'required',
            ],
        ];
    }
}
