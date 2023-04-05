<x-layouts.admin>
    <x-slot name="title">
        {{ trans_choice('credit-debit-notes::general.credit_notes', 1) }}
    </x-slot>

    <x-slot name="content">
        <x-form.container>
            <x-form id="setting" method="PATCH" route="credit-debit-notes.settings.credit-note.update">
                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head title="{{ trans('general.general') }}" description="{{ trans('credit-debit-notes::settings.credit_note.form_description.general') }}" />
                    </x-slot>

                    <x-slot name="body">
                        <x-form.group.text name="number_prefix" label="{{ trans('credit-debit-notes::settings.credit_note.prefix') }}"  value="{{ setting('credit-debit-notes.credit_note.number_prefix') }}" not-required />

                        <x-form.group.text name="number_digit" label="{{ trans('credit-debit-notes::settings.credit_note.digit') }}"  value="{{ setting('credit-debit-notes.credit_note.number_digit') }}" not-required />

                        <x-form.group.text name="number_next" label="{{ trans('credit-debit-notes::settings.credit_note.next') }}" value="{{ setting('credit-debit-notes.credit_note.number_next') }}" not-required />
                    </x-slot>
                </x-form.section>

                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head title=" {{ trans_choice('general.templates', 1) }}" description="{{ trans('credit-debit-notes::settings.credit_note.form_description.template') }}" />
                    </x-slot>

                    <x-slot name="body">
                        <div class="sm:col-span-2 rounded-lg cursor-pointer text-center py-2 px-2">
                            <label class="cursor-pointer">
                                <div @click="form.template='default'">
                                    <img src="{{ asset('public/img/invoice_templates/default.png') }}" class="h-60 my-3" alt="Default" />
                                    <input type="radio" name="template" value="default" v-model="form._template">
                                    {{ trans('credit-debit-notes::settings.credit_note.default') }}
                                </div>
                            </label>
                        </div>

                        <div class="sm:col-span-2 rounded-lg cursor-pointer text-center py-2 px-2">
                            <label class="cursor-pointer">
                                <div @click="form.template='classic'">
                                    <img src="{{ asset('public/img/invoice_templates/classic.png') }}" class="h-60 my-3" alt="Classic" />
                                    <input type="radio" name="template" value="classic" v-model="form._template">
                                    {{ trans('credit-debit-notes::settings.credit_note.classic') }}
                                </div>
                            </label>
                        </div>

                        <div class="sm:col-span-2 rounded-lg cursor-pointer text-center py-2 px-2">
                            <label class="cursor-pointer">
                                <div @click="form.template='modern'">
                                    <img src="{{ asset('public/img/invoice_templates/modern.png') }}" class="h-60 my-3" alt="Modern" />
                                    <input type="radio" name="template" value="modern" v-model="form._template">
                                    {{ trans('credit-debit-notes::settings.credit_note.modern') }}
                                </div>
                            </label>
                        </div>

                        <x-form.group.color name="color" label="{{ trans('general.color') }}" />
                    </x-slot>
                </x-form.section>

                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head title="{{ trans_choice('general.defaults', 2) }}" description="{{ trans('credit-debit-notes::settings.credit_note.form_description.default') }}" />
                    </x-slot>

                    <x-slot name="body">
                        <x-form.group.text name="title" label="{{ trans('credit-debit-notes::settings.credit_note.title') }}" value="{{ setting('credit-debit-notes.credit_note.title') }}" not-required />

                        <x-form.group.text name="subheading" label="{{ trans('credit-debit-notes::settings.credit_note.subheading') }}" value="{{ setting('credit-debit-notes.credit_note.subheading') }}" not-required />

                        <x-form.group.textarea name="notes" label="{{ trans_choice('general.notes', 2) }}" :value="setting('credit-debit-notes.credit_note.notes')" form-group-class="sm:col-span-3" />

                        <x-form.group.textarea name="footer" label="{{ trans('general.footer') }}" :value="setting('credit-debit-notes.credit_note.footer')" form-group-class="sm:col-span-3" />
                    </x-slot>
                </x-form.section>

                @can('update-credit-debit-notes-settings-credit-note')
                    <x-form.section>
                        <x-slot name="foot">
                            <x-form.buttons :cancel="url()->previous()" />
                        </x-slot>
                    </x-form.section>
                @endcan

                <x-form.input.hidden name="_template" :value="setting('credit-debit-notes.credit_note.template')" />
                <x-form.input.hidden name="_prefix" value="credit-debit-notes.credit_note" />
            </x-form>
        </x-form.container>
    </x-slot>

    <x-script alias="credit-debit-notes" folder="" file="settings" />
</x-layouts.admin>
