<x-layouts.portal>
    <x-slot name="title">
        {{ trans_choice('credit-debit-notes::general.credit_notes', 2) }}
    </x-slot>

    <x-slot name="favorite"
            :title="trans_choice('credit-debit-notes::general.credit_notes', 2)"
            icon="description"
            route="credit-debit-notes.credit-notes.index"
    ></x-slot>

    <x-slot name="buttons">
        <x-documents.index.buttons
            type="credit-note"
            check-create-permission
        />
    </x-slot>

    <x-slot name="moreButtons">
        <x-documents.index.more-buttons type="credit-note" />
    </x-slot>

    {{--TODO: fix getting page in the App\Traits\ViewComponents
    replace dashes with undescore
    --}}
    <x-slot name="content">
        <x-documents.index.content
            type="credit-note"
            page="credit_notes"
            :documents="$credit_notes"
            active-tab="credit-note"
            hide-bulk-action
            hide-contact-name
            hide-actions
            hide-empty-page
            hide-due-at
            hide-import
            url-docs-path="https://akaunting.com/docs/app-manual/accounting/credit-debit-notes"
            form-card-header-route="portal.invoices.index"
            route-button-show="portal.credit-debit-notes.credit-notes.show"
            class-document-number="col-xs-4 col-sm-4 col-md-3 disabled-col-aka"
            class-amount="col-xs-4 col-sm-2 col-md-3 text-right"
            class-issued-at="col-sm-3 col-md-3 d-none d-sm-block"
            class-status="col-xs-4 col-sm-3 col-md-3 text-center"
            search-string-model="Modules\CreditDebitNotes\Models\Portal\CreditNote"
        />
    </x-slot>

    <x-documents.script :src="asset('public/js/portal/invoices.js?v=' . version('short'))" />
</x-layouts.portal>
