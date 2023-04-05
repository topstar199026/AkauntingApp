<div class="small-table-width">
    <x-table class="flex flex-col divide-y divide-gray-200">
        <x-table.thead>
            <x-table.tr>
                <x-table.th class="w-7/12">
                    {{ trans_choice('inventory::general.warehouses', 1) }}
                    <label class="text-red-600">*</label>
                </x-table.th>
    
                <x-table.th class="w-2/12 text-center">
                    <x-tooltip placement="top" message="{{ trans('inventory::items.opening_stock') }}">
                        {{ trans('inventory::items.sort_opening_stock') }}
                        <label class="text-red-600">*</label>
                    </x-tooltip>
                </x-table.th>
    
                <x-table.th class="w-2/12 text-center">
                    <x-tooltip placement="top" message="{{ trans('inventory::items.reorder_level') }}">
                        {{ trans('inventory::items.sort_reorder_level') }}
                    </x-tooltip>
                </x-table.th>
    
                <x-table.th class="w-1/12"></x-table.th>
            </x-table.tr>
        </x-table.thead>
    
        <x-table.tbody>
            <x-table.tr class="relative flex items-center px-1 group/actions border-b" v-for="(row, index) in form.items" ::index="index">
                <x-table.td class="w-7/12">
                    <div class="flex flex-row items-center">
                        <akaunting-select
                            class="form-element-sm d-inline-block w-9/12"
                            :placeholder="'{{ trans('general.form.select.field', ['field' => trans_choice('inventory::general.warehouses', 1)])  }}'"
                            :name="'items.' + index + '.warehouse_id'"
                            :options="{{ json_encode($warehouses) }}"
                            :value="'{{ setting('inventory.default_warehouse') }}'"
                            @interface="row.warehouse_id = $event">
                        </akaunting-select>
    
                        <div class="w-3/12 p-3">
                            <label>
                                <input type="radio"
                                    name="items[][default_warehouse]"
                                    :id="'default-warehouse-' + index"
                                    data-item="default_warehouse"
                                    :value="'true'"
                                    @change="onChangeDefault(index)"
                                    v-model="row.default_warehouse"
                                >
                                    {{ trans('inventory::general.default') }}
                            </label>
                        </div>
                    </div>
                </x-table.td>
    
                <x-table.td class="w-2/12">
                    <div class="flex flex-col" :class="[{'has-error': form.errors.has('items.' + index + '.opening_stock') }]">
                        <input
                            class="w-full text-sm px-3 py-2.5 mt-1 rounded-lg border border-light-gray text-black placeholder-light-gray bg-white disabled:bg-gray-200 focus:outline-none focus:ring-transparent focus:border-purple"
                            data-item="opening_stock"
                            name="items.' + index + '.opening_stock'"
                            v-model="row.opening_stock"
                            type="text"
                            autocomplete="off"
                        >
                        <span class="invalid-feedback block text-xs text-red whitespace-normal"
                            v-if="form.errors.has('items.' + index + '.opening_stock')"
                            v-html="form.errors.get('items.' + index + '.opening_stock')">
                        </span>
                    </div>
                </x-table.td>
    
                <x-table.td class="w-2/12">
                    <x-form.group.text name="items[][reorder_level]" data-item="reorder_level" v-model="row.reorder_level" />
                </x-table.td>
    
                <x-table.td class="w-1/12 none-truncate" override="class">
                    <x-button type="button" @click="onDeleteItem(index)" class="px-3 py-1.5 mb-3 sm:mt-2 sm:mb-0 rounded-xl text-sm font-medium leading-6 hover:bg-gray-200 disabled:bg-gray-50" override="class">
                        <span class="w-full material-icons-outlined text-lg text-gray-300 group-hover:text-gray-500">delete</span>
                    </x-button>
                </x-table.td>
            </x-table.tr>
    
            <x-table.tr id="addItem">
                <x-table.td class="w-full">
                    <x-button type="button" override="class" @click="onAddItem" class="w-full text-secondary flex items-center justify-center" title="{{ trans('general.add') }}">
                        <span class="material-icons-outlined text-base font-bold mr-1">add</span>
                        {{ trans('general.form.add', ['field' => trans_choice('inventory::general.warehouses', 1)]) }}
                    </x-button>
                </x-table.td>
            </x-table.tr>
        </x-table.tbody>
    </x-table>
</div>