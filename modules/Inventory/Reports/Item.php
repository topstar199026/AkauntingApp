<?php

namespace Modules\Inventory\Reports;

use Akaunting\Apexcharts\Chart as Apexcharts;
use App\Abstracts\Report;
use App\Utilities\Date;
use App\Models\Document\DocumentItem;
use App\Models\Common\Item as CoreItem;
use Modules\Inventory\Models\History;

class Item extends Report
{
    public $default_name = 'inventory::general.reports.name.stock_status';

    public $category = 'inventory::general.name';

    public $icon = 'inventory_2';

    public $type = 'summary';

    public $bar_formatter_type = 'integer';

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

    public function setViews()
    {
        parent::setViews();
        $this->views['detail.table.footer'] = 'inventory::partials.reports.detail.table.footer';
        $this->views['detail.table.row'] = 'inventory::partials.reports.detail.table.row';
        $this->views['summary.table.body'] = 'inventory::partials.reports.summary.table.body';
        $this->views['summary.table.row'] = 'inventory::partials.reports.summary.table.row';
    }

    public function setTables()
    {
        $this->tables = [
            'item' => trans_choice('general.items', 2),
        ];
    }

    public function setData()
    {
        $items = CoreItem::collect();

        if (! $items->count()) {
            return;
        }

        foreach ($items as $key => $item) {
            if (! $item->inventory()->first()) {
                unset($items[$key]);
                continue;
            }

            $histories = $this->applyFilters(History::where('item_id', $item->id), ['date_field' => 'created_at'])->get();

            if (! $histories->count()) {
                continue;
            }

            foreach ($histories as $history) {
                $date = $this->getFormattedDate(Date::parse($history->created_at));

                if (empty($date)) {
                    continue;
                }

                if ($history->type_type == 'App\Models\Common\Item') {
                    $this->row_values['item'][$item->id][$date] += $history->quantity;
                    $this->footer_totals['item'][$date] += $history->quantity;
                } elseif ($history->type_type == 'Modules\Inventory\Models\Item') {
                    $this->row_values['item'][$item->id][$date] += $history->quantity;
                    $this->footer_totals['item'][$date] += $history->quantity;
                } elseif ($history->type_type == 'Modules\Inventory\Models\Adjustment') {
                    $this->row_values['item'][$item->id][$date] -= $history->quantity;
                    $this->footer_totals['item'][$date] -= $history->quantity;
                } elseif ($history->type_type == 'App\Models\Document\DocumentItem') {
                    $document_type = DocumentItem::where('id', $history->type_id)->value('type');
                    
                    if (!empty($document_type)) {
                        if ($document_type == 'bill') {
                            $this->row_values['item'][$item->id][$date] += $history->quantity;
                            $this->footer_totals['item'][$date] += $history->quantity;
                        } elseif ($document_type == 'invoice') {
                            $this->row_values['item'][$item->id][$date] -= $history->quantity;
                            $this->footer_totals['item'][$date] -= $history->quantity;
                        }
                    }
                }
            }
        }
    }
    
    public function getBarChart($table_key)
    {
        $chart = new Apexcharts();

        if (empty($this->chart)) {
            return $chart;
        }

        $end_date = $this->getFormattedDate(Date::now());

        foreach ($this->footer_totals[$table_key] as $key => $value) {
            $last_date = $this->getFormattedDate(Date::parse($key)->subMonth());

            if (strpos($last_date, 'Dec') !== false) {
                continue;
            }

            $this->footer_totals[$table_key][$key] += isset($this->footer_totals[$table_key][$last_date]) ? $this->footer_totals[$table_key][$last_date] : 0;

            if ($key == $end_date) {
                break;
            }
        }

        $options = !empty($this->chart[$table_key]) ? $this->chart[$table_key]['bar'] : $this->chart['bar'];

        $chart->setType('bar')
            ->setOptions($options)
            ->setLabels(array_values($this->dates))
            ->setDataset($this->tables[$table_key], 'column', array_values($this->footer_totals[$table_key]));

        return $chart;
    }
}
