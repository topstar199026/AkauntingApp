<?php

namespace Modules\Projects\Exports;

use App\Utilities\Date;
use App\Abstracts\Export;
use App\Models\Document\Document;
use App\Models\Banking\Transaction;
use Modules\Projects\Models\Project;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class TransactionsExport extends Export implements WithColumnFormatting
{
    public function collection()
    {
        $project = Project::find($this->ids);

        $invoices = collect(Document::invoice()->whereIn('id', $project->invoices->pluck('invoice_id'))->orderBy('issued_at', 'desc')->get())->each(function ($invoice) {
            $invoice->paid_at = $invoice->issued_at;
        });

        $revenues = collect(Transaction::whereIn('id', $project->revenues->pluck('revenue_id'))->orderBy('paid_at', 'desc')
                ->isNotTransfer()
                ->get());

        $bills = collect(Document::bill()->whereIn('id', $project->bills->pluck('bill_id'))->orderBy('issued_at', 'desc')->get())->each(function ($bill) {
            $bill->paid_at = $bill->issued_at;
        });

        $payments = collect(Transaction::whereIn('id', $project->payments->pluck('payment_id'))->orderBy('paid_at', 'desc')
                ->isNotTransfer()
                ->get());

        $financials = $invoices->merge($revenues)
            ->merge($bills)
            ->merge($payments);

        return $financials;
    }

    public function map($model): array
    {
        $model->category_name = trans('general.na');

        if (!empty($model->category)) {
            $model->category_name = ($model->category) ? $model->category->name : trans('general.na');
        }

        if ($model->document_number) {
            $model->description = $model->notes;
        }

        if ($model->document_number) {
            $model->type = ucfirst($model->type);
        }
        
        if ($model->type === 'income') {
            $model->type = trans_choice('general.revenues', 1);
        } 
        
        if ($model->type === 'expense') {
            $model->type = trans_choice('general.payments', 1);
        }

        $model->transaction_at = ExcelDate::dateTimeToExcel(Date::parse($model->paid_at));
        $model->transaction_amount = money($model->amount, $model->currency_code, true)->format();
        $model->document_paid_at = ExcelDate::dateTimeToExcel(Date::parse($model->paid_at));

        return parent::map($model);
    }

    public function fields(): array
    {
        return [
            'document_paid_at',
            'amount',
            'category_name',
            'transaction_at',
            'transaction_amount',
            'description',
            'type',
        ];
    }

    public function headings(): array
    {
        return [
            'paid_at',
            'amount',
            'category_name',
            'transaction_at',
            'transaction_amount',
            'description',
            'type',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => company_date_format(),
            'D' => company_date_format(),
        ];
    }
}
