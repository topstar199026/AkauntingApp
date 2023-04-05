<?php

namespace Modules\TimeToGetPaid\Reports;

use App\Abstracts\Report;
use App\Models\Banking\Transaction;
use App\Models\Document\Document;
use Date;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class PaymentTimes extends Report
{
    public $category = 'general.accounting';

    public $icon = 'assessment';

    public $periods;

    public $asAt;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $rows;

    public function load()
    {
        $this->periods = config('time-to-get-paid.periods');

        foreach ($this->periods as $index => $period) {
            $this->dates[$index + 1] = $period['name'];
        }

        parent::load();
    }

    public function setData()
    {
        $this->rows = collect();
        $this->asAt = $this->getSetting('as_of') ? Date::parse($this->getSetting('as_of')) : Date::now();

        $keyBy = 'contact_id';

        $documents = Document::invoice()
            ->when(request('search'), function (Builder $builder) use ($keyBy) {
                $this->filterByName($builder, $keyBy, trim(request('search'), '"'));
            })
            ->accrued()
            ->Paid()
            ->where('due_at', '<=', $this->asAt)
            ->get();

        $documents->each(function ($document) use ($keyBy) {
            $diff = $document->due_at->diffInDays($this->asAt, false);
            $this->periods = config('time-to-get-paid.periods');

            $key = $this->getKeyName($document, $keyBy);
            $row = $this->rows->get($key['key'], function () use ($key) {
                $row['key'] = $key['label'];

                foreach ($this->periods as $period) {
                    $row[$period['slug']] = 0;
                }

                return $row;
            });

            foreach ($this->periods as $period) {
                if ((is_null($period['min']) || $diff >= $period['min']) && (is_null($period['max']) || $diff <= $period['max'])) {
                    $row[$period['slug']] += 1;
                }
            }

            $this->rows->put($key['key'], $row);
        });

        foreach ($this->rows as $key => $item) {
            foreach ($item as $itemKey => $arrayField) {
                if ($itemKey !== 'key') {
                    $item[$itemKey] = round($arrayField * 100 / $this->getInvoiceCount($key), 2);
                    $this->rows->put($key, $item);
                }
            }
        }
    }

    public function getFields()
    {
        return [];
    }

    public function setViews()
    {
        parent::setViews();
        $this->views['detail'] = 'time-to-get-paid::reports.table.detail';
    }

    protected function getKeyName($doc, $keyBy)
    {
        if ($keyBy == 'contact_id') {
            return ['label' => $doc->contact->name, 'key' => $doc->contact_id];
        }
    }

    protected function getInvoiceCount($id): int
    {
        return Document::invoice()->where('contact_id', $id)->where('status', 'paid')
            ->where('due_at', '<=', $this->asAt)
            ->count();
    }

    protected function filterByName(Builder $builder, $keyBy, $term)
    {
        if ($keyBy == 'contact_id') {
            $builder->whereHas('contact', function (Builder $builder) use ($term) {
                $builder->where('name', 'like', '%' . $term . '%');
            });
        }
    }
}
