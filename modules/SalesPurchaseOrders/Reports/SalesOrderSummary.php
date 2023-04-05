<?php

namespace Modules\SalesPurchaseOrders\Reports;

use App\Abstracts\Report;
use Modules\SalesPurchaseOrders\Models\SalesOrder\Model;

class SalesOrderSummary extends Report
{
    public $default_name = 'sales-purchase-orders::sales_orders.summary_report_type';

    public $icon = 'check';

    public $type = 'summary';

    public $chart = [
        'bar' => [
            'colors' => [
                '#8bb475',
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
            case 'invoiced':
                $this->setTotals(Model::sales()->invoiced()->get(), 'issued_at');

                break;
            default:
                $documents = $this->applyFilters(Model::sales()->accrued(), ['date_field' => 'issued_at'])->get();
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
                'invoiced' => trans('sales-purchase-orders::sales_orders.statuses.invoiced'),
            ],
            'selected' => 'accrual',
            'attributes' => [
                'required' => 'required',
            ],
        ];
    }
}
