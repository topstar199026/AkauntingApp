<x-layouts.admin>
    <x-slot name="title">
        {{ trans('mt940::general.title') . ' - ' . trans('general.title.new', ['type' => trans_choice('general.accounts', 1)]) }}
    </x-slot>

    <x-slot name="content">
        <x-form.container>
            <x-form
                id="mt940"
                route="mt940.bank">
                <x-form.section>
                    <x-slot name="body">
                        <x-form.group.text
                            name="bankName"
                            :label="trans('accounts.bank_name')"
                            :value="session('parsedStatement')->getBank()"
                        />

                        <x-form.group.text
                            name="bankId"
                            :label="trans('accounts.number')"
                            :value="session('parsedStatement')->getAccount()"
                            readonly
                            disabled
                        />
                    </x-slot>
                </x-form.section>

                <x-form.section>
                    <x-slot name="foot">
                        <x-form.buttons cancel-route="mt940.create" />
                    </x-slot>
                </x-form.section>
            </x-form>
        </x-form.container>
    </x-slot>

    <x-script
        alias="mt940"
        file="mt940"
    />
</x-layouts.admin>
