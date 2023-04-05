<x-layouts.admin>
    <x-slot name="title">{{ trans('receipt::general.title') }}</x-slot>

    <x-slot name="content">
        <x-form.container>
            <x-form id="receipt" route="receipt.store">
                <x-form.section>
                    <x-slot name="body">
                        <div class="sm:col-span-3">
                            <x-form.group.file name="attachment" label="{{ trans('general.form.select.file') }}"
                                               required/>
                        </div>
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

