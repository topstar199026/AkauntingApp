<?php

namespace Modules\AgedReceivablesPayables\Reports;

use App\Abstracts\Report;
use App\Models\Document\Document;
use Date;

class AgedPayables extends AgedTransactions
{
    public $aged_type = 'payables';

    public $default_name = 'aged-receivables-payables::general.aged-payables';

    public $icon = 'receipt';

    public function getDocumentsQuery()
    {
        return Document::bill();
    }
}
