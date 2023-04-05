<x-layouts.admin>
    <x-slot name="title">
        {{ trans_choice('credit-debit-notes::general.debit_notes', 1) }}
    </x-slot>

    <x-slot name="content">
        <x-form.container>
            <x-form id="setting" method="PATCH" route="credit-debit-notes.settings.debit-note.update">
                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head title="{{ trans('general.general') }}" description="{{ trans('credit-debit-notes::settings.debit_note.form_description.general') }}" />
                    </x-slot>

                    <x-slot name="body">
                        <x-form.group.text name="number_prefix" label="{{ trans('credit-debit-notes::settings.debit_note.prefix') }}"  value="{{ setting('credit-debit-notes.debit_note.number_prefix') }}" not-required />

                        <x-form.group.text name="number_digit" label="{{ trans('credit-debit-notes::settings.debit_note.digit') }}"  value="{{ setting('credit-debit-notes.debit_note.number_digit') }}" not-required />

                        <x-form.group.text name="number_next" label="{{ trans('credit-debit-notes::settings.debit_note.next') }}" value="{{ setting('credit-debit-notes.debit_note.number_next') }}" not-required />
                    </x-slot>
                </x-form.section>

                @can('update-credit-debit-notes-settings-debit-note')
                    <x-form.section>
                        <x-slot name="foot">
                            <x-form.buttons :cancel="url()->previous()" />
                        </x-slot>
                    </x-form.section>
                @endcan

                <x-form.input.hidden name="_prefix" value="credit-debit-notes.debit_note" />
            </x-form>
        </x-form.container>
    </x-slot>

    <x-script alias="credit-debit-notes" folder="" file="settings" />
</x-layouts.admin>
