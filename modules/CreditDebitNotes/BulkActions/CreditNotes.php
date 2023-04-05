<?php

namespace Modules\CreditDebitNotes\BulkActions;

use App\Abstracts\BulkAction;
use App\Events\Document\DocumentCancelled;
use App\Events\Document\DocumentMarkedSent;
use App\Jobs\Document\DeleteDocument;
use Exception;
use Modules\CreditDebitNotes\Models\CreditNote as Document;

class CreditNotes extends BulkAction
{
    public $model = Document::class;

    public $text = 'credit-debit-notes::general.credit_notes';

    public $path = [
        'group' => 'credit-debit-notes',
        'type'  => 'credit-notes',
    ];

    public $actions = [
        'sent'      => [
            'icon'       => 'send',
            'name'       => 'credit-debit-notes::credit_notes.mark_sent',
            'message'    => 'credit-debit-notes::bulk_actions.message.sent',
            'permission' => 'update-credit-debit-notes-credit-notes',
        ],
        'cancelled' => [
            'icon'       => 'cancel',
            'name'       => 'general.cancel',
            'message'    => 'credit-debit-notes::bulk_actions.message.cancelled',
            'permission' => 'update-credit-debit-notes-credit-notes',
        ],
        'delete'    => [
            'icon'       => 'delete',
            'name'       => 'general.delete',
            'message'    => 'credit-debit-notes::bulk_actions.message.delete',
            'permission' => 'delete-credit-debit-notes-credit-notes',
        ],
        // TODO: implement export
//        'export' => [
//            'icon'          => 'file_download',
//            'name' => 'general.export',
//            'message' => 'bulk_actions.message.export',
//            'type' => 'download',
//        ],
    ];

    public function sent($request)
    {
        $credit_notes = $this->getSelectedRecords($request);

        foreach ($credit_notes as $credit_note) {
            event(new DocumentMarkedSent($credit_note));
        }
    }

    public function cancelled($request)
    {
        $credit_notes = $this->getSelectedRecords($request);

        foreach ($credit_notes as $credit_note) {
            event(new DocumentCancelled($credit_note));
        }
    }

    public function destroy($request)
    {
        $credit_notes = $this->getSelectedRecords($request);

        foreach ($credit_notes as $credit_note) {
            try {
                $this->dispatch(new DeleteDocument($credit_note));
            } catch (Exception $e) {
                flash($e->getMessage())->error()->important();
            }
        }
    }

    public function export($request)
    {
        // TODO: implement export
//        $selected = $this->getSelectedInput($request);
//
//        return \Excel::download(new Export($selected), \Str::filename(trans_choice('credit-debit-notes::general.credit_notes', 2)) . '.xlsx');
    }
}
