<x-layouts.admin>
    <x-slot name="title">{{ trans_choice('general.settings', 2) }}</x-slot>

    <x-slot name="content">
        <x-form.container>
            <x-form id="receipt" method="POST" route="receipt.setting.store">

                <x-form.section>
                    <x-slot name="body">
                        <x-form.group.select name="platform" label="{{ trans('receipt::general.platform') }}" :options="$platforms" :selected="setting('receipt.platform')" required />

                        <x-form.group.text name="api_key" label="{{ trans('receipt::general.api_key') }}" value="{{ setting('receipt.api_key') }}"/>
                    </x-slot>
                </x-form.section>

                <x-form.section>
                    <x-slot name="foot">
                        <x-form.buttons cancel-route="receipt.index"/>
                    </x-slot>
                </x-form.section>
            </x-form>
        </x-form.container>
    </x-slot>

    <x-script alias="receipt" file="receipts"/>
</x-layouts.admin>
