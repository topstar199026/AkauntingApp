<?php

namespace Modules\Calendar\Traits;

use App\Utilities\Date;

trait Calendar
{
    public function applyFilters($model, $args = ['date_field' => 'paid_at'])
    {
        if (request()->route()->getName() === 'dashboard') {
            $start_date = request()->get('start_date') . ' 00:00:00';
            $end_date = request()->get('end_date') . ' 23:59:59';
        } else {
            $start_date = Date::now()->addYear(-1)->firstOfYear()->toDateTimeString();
            $end_date = Date::now()->addYear(1)->lastOfYear()->toDateTimeString();
        }

        return $model->whereBetween($args['date_field'], [$start_date, $end_date]);
    }
}
