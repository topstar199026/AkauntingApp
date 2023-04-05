<?php

namespace Modules\Receipt\Jobs;

use App\Abstracts\Job;
use Exception;
use Modules\Receipt\Traits\Api;
use Date;

class TaggunJob extends Job
{
    use Api;

    private $file;
    private $receipt;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($file, $receipt)
    {
        $this->file = $file;
        $this->receipt = $receipt;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $resultReceipt = json_decode($this->getReceipts($this->file));

            $create_date = Date::now();

            if (empty($resultReceipt->date->data)) {
                $date = $create_date;
            } else {
                $date = $resultReceipt->date->data;
            }
            if (empty($resultReceipt->merchantName->data)) {
                $merchant_name = null;
            } else {
                $merchant_name = $resultReceipt->merchantName->data;
            }
            if (empty($resultReceipt->totalAmount->data)) {
                $total_amount = 0;
            } else {
                $total_amount = $resultReceipt->totalAmount->data;
            }
            if (empty($resultReceipt->taxAmount->data)) {
                $tax_amount = 0;
            } else {
                $tax_amount = $resultReceipt->taxAmount->data;
            }

            $this->receipt->update([
                'company_id' => company_id(),
                'date' => Date::parse($date)->format('Y-m-d h:i:s'),
                'statuses' => trans('documents.statuses.draft'),
                'create_date' => $create_date,
                'merchant' => $merchant_name ?? trans('general.na'),
                'total_amount' => $total_amount,
                'tax_amount' => $tax_amount,
                'category_id' => null,
                'payment_id' => null,
                'payment_method' => '',
            ]);
        } catch (Exception $exception) {
        }
    }
}
