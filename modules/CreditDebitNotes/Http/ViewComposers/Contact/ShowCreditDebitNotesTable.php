<?php

namespace Modules\CreditDebitNotes\Http\ViewComposers\Contact;

use App\Models\Common\Contact;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\View\View;
use Modules\CreditDebitNotes\Models\CreditNote;
use Modules\CreditDebitNotes\Models\DebitNote;

class ShowCreditDebitNotesTable
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $viewData = $view->getData();

        $contact = $viewData['contact'];

        if ($contact->type === Contact::CUSTOMER_TYPE) {
            $entity_kebab = 'credit-notes';
            $entity_snake = 'credit_notes';
            $model = CreditNote::class;
        } elseif ($contact->type === Contact::VENDOR_TYPE) {
            $entity_kebab = 'debit-notes';
            $entity_snake = 'debit_notes';
            $model = DebitNote::class;
        } else {
            return;
        }

        if (user()->cant('read-credit-debit-notes-' . $entity_kebab)) {
            return;
        }

        $notes = $model::orderBy('issued_at', 'desc')
            ->contact($contact->id)
            ->get();

        $view->getFactory()->startPush(
            'transactions_nav_end',
            view('credit-debit-notes::partials.' . $contact->type . '.' . $entity_snake . '_nav')
        );

        $view->getFactory()->startPush(
            'transactions_tab_end',
            view(
                'credit-debit-notes::partials.' . $contact->type . '.' . $entity_snake . '_tab',
                [
                    $entity_snake => $this->paginate($notes),
                    'limits'      => ['10' => '10', '25' => '25', '50' => '50', '100' => '100'],
                    'contact'     => $viewData['contact'],
                    'type'        => $viewData['type'],
                ]
            )
        );
    }

    public function paginate($items, $perPage = null, $page = null, $options = []): LengthAwarePaginator
    {
        $perPage = $perPage ?: request('limit', setting('default.list_limit', '25'));

        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
