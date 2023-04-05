<?php

namespace Modules\AgedReceivablesPayables\Reports;

use App\Models\Document\Document;

class AgedReceivables extends AgedTransactions
{
    public $aged_type = 'receivables';

    public $default_name = 'aged-receivables-payables::general.aged-receivables';

    public $icon = 'pending_actions';

    public function getDocumentsQuery()
    {
        return Document::invoice();
    }
}
