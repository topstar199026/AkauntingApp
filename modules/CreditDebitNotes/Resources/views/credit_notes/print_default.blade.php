<x-layouts.print>
    <x-slot name="title">
        {{ trans_choice('credit-debit-notes::general.credit_notes', 1).': '.$credit_note->document_number }}
    </x-slot>

    <x-slot name="content">
        <x-documents.template.ddefault
            type="credit-note"
            :document="$credit_note"
            hide-due-at
        />
    </x-slot>
</x-layouts.print>
