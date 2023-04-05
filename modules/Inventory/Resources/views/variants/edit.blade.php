<x-layouts.admin>
    <x-slot name="title">{{ trans('general.title.edit', ['type' => trans_choice('inventory::general.variants', 1)]) }}</x-slot>

    <x-slot name="content">
        <x-form.container>
            <x-form id="variant" method="PATCH" :route="['inventory.variants.update', $variant->id]" :model="$variant">
                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head title="{{ trans('general.general') }}" />
                    </x-slot>

                    <x-slot name="body">
                        <x-form.group.text name="name" label="{{ trans('general.name') }}" />
                    </x-slot>
                </x-form.section>

                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head title="{{ trans_choice('inventory::variants.values',  2) }}" />
                    </x-slot>
                    <x-slot name="body">
                        <div class="sm:col-span-6 overflow-x-scroll large-overflow-unset">
                            <div class="small-table-width">
                                <x-table class="flex flex-col divide-y divide-gray-200">
                                    <x-table.thead>
                                        <x-table.tr>
                                            <x-table.th class="w-11/12">
                                                {{ trans('general.name') }}
                                            </x-table.th>
                                            
                                            <x-table.td class="w-1/12"></x-table.td>
                                        </x-table.tr>
                                    </x-table.thead>
                                
                                    <x-table.tbody>
                                        <x-table.tr class="relative flex items-center px-1 group/actions border-b" v-for="(row, index) in form.items" ::index="index">
                                            <x-table.td class="w-11/12">
                                                <x-form.group.text name="items[][name]" value="" data-item="name" v-model="row.name" />
                                            </x-table.td>

                                            <x-table.td class="w-1/12">
                                                <x-button type="button" @click="onDeleteItem(index)" class="px-3 py-1.5 mb-3 sm:mt-2 sm:mb-0 rounded-xl text-sm font-medium leading-6 hover:bg-gray-200 disabled:bg-gray-50" override="class">
                                                    <span class="w-full material-icons-outlined text-lg text-gray-300 group-hover:text-gray-500">delete</span>
                                                </x-button>
                                            </x-table.td>
                                        </x-table.tr>
                                        
                                        <x-table.tr id="addItem">
                                            <x-table.td class="w-full">
                                                <x-button type="button" override="class" @click="onAddItem" class="w-full text-secondary flex items-center justify-center" title="{{ trans('general.add') }}">
                                                    <span class="material-icons-outlined text-base font-bold mr-1">add</span>
                                                    {{ trans('general.form.add', ['field' => trans_choice('inventory::variants.values', 1)]) }}
                                                </x-button>
                                            </x-table.td>
                                        </x-table.tr>
                                    </x-table.tbody>
                                </x-table>
                            </div>
                        </div>
                    </x-slot>
                </x-form.section>

                <x-form.group.switch name="enabled" label="{{ trans('general.enabled') }}" />

                <x-form.section>
                    <x-slot name="foot">
                        <x-form.buttons cancel-route="inventory.variants.index" />
                    </x-slot>
                </x-form.section>
            </x-form>
        </x-form.container>
    </x-slot>

    @push('scripts_start')
        <script type="text/javascript">
            var variant_items = {!! json_encode($variant->values()->select(['name'])->get()) !!};
        </script>
    @endpush

    <x-script alias="inventory" file="variants" />
</x-layouts.admin>

