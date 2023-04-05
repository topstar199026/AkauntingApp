<?php

namespace Modules\Receipt\Exports;

use App\Abstracts\Export;
use Modules\Receipt\Models\Receipt as Model;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class Receipts extends Export implements WithColumnFormatting
{
    public function collection()
    {
        return Model::with(['contact', 'category'])->collectForExport($this->ids, ['paid_at' => 'desc']);
    }

    public function map($model): array
    {
        $model->contact_name = $model->contact->name;
        $model->contact_email = $model->contact->email;
        $model->contact_tax_number = $model->contact->tax_number;
        $model->category_name = $model->category->name;

        return parent::map($model);
    }

    public function fields(): array
    {
        return [
            'date',
            'merchant',
            'contact_name',
            'contact_email',
            'contact_tax_number',
            'total_amount',
            'tax_amount',
            'currency_code',
            'category_name',
            'payment_method',
            'statuses',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_YYYYMMDD,
        ];
    }
}
