<x-layouts.signed>
    <x-slot name="title">
        {{ trans_choice('credit-debit-notes::general.credit_notes', 1) . ': ' . $credit_note->document_number }}
    </x-slot>

    <x-slot name="status">
        <x-show.status status="{{ $credit_note->status }}"
                       background-color="bg-{{ $credit_note->status_label }}"
                       text-color="text-text-{{ $credit_note->status_label }}"
        />
    </x-slot>

    <x-slot name="buttons">
        <x-documents.show.buttons type="credit-note" :document="$credit_note" />
    </x-slot>

    <x-slot name="moreButtons">
        <x-documents.show.more-buttons type="credit-note" :document="$credit_note" />
    </x-slot>

{{--@section('new_button')--}}
{{--    @stack('button_print_start')--}}
{{--    <a href="{{ $print_action }}" target="_blank" class="btn btn-white btn-sm">--}}
{{--        {{ trans('general.print') }}--}}
{{--    </a>--}}
{{--    @stack('button_print_end')--}}

{{--    @stack('button_pdf_start')--}}
{{--    <a href="{{ $pdf_action }}" class="btn btn-white btn-sm">--}}
{{--        {{ trans('general.download') }}--}}
{{--    </a>--}}
{{--    @stack('button_pdf_end')--}}

{{--    @stack('button_dashboard_start')--}}
{{--    <a href="{{ route('portal.dashboard') }}" class="btn btn-white btn-sm">--}}
{{--        {{ trans('credit-debit-notes::credit_notes.all_credit_notes') }}--}}
{{--    </a>--}}
{{--    @stack('button_dashboard_end')--}}
{{--@endsection--}}

    <x-slot name="content">
        <x-documents.show.content
            type="credit-note"
            :document="$credit_note"
            hide-receive
            hide-make-payment
            hide-schedule
            hide-children
            hide-due-at
            hide-header-due-at
            hide-button-received
            hide-button-email
            hide-timeline-paid
            hide-header-contact
            hide-header-due-at
            class-header-status="col-md-8"
            document-template="{{ setting('credit-debit-notes.credit_note.template', 'default') }}"
        />
    </x-slot>

    @push('stylesheet')
        <link rel="stylesheet" href="{{ asset('public/css/print.css?v=' . version('short')) }}" type="text/css">
    @endpush

    <x-documents.script script-file="{{ asset('public/js/portal/invoices.js?v=' . version('short')) }}" />
</x-layouts.signed>
