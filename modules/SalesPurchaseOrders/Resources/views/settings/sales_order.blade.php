<x-layouts.admin>
    <x-slot name="title">
        {{ trans_choice('sales-purchase-orders::general.sales_orders', 1) }}
    </x-slot>

    <x-slot name="content">
        <x-form.container>
            <x-form id="setting" method="PATCH" route="sales-purchase-orders.settings.sales-order.update">
                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head title="{{ trans('general.general') }}" description="{{ trans('sales-purchase-orders::settings.sales_order.form_description.general') }}" />
                    </x-slot>

                    <x-slot name="body">
                        <x-form.group.text name="number_prefix" label="{{ trans('settings.invoice.prefix') }}"  value="{{ setting('sales-purchase-orders.sales_order.number_prefix') }}" not-required />

                        <x-form.group.text name="number_digit" label="{{ trans('settings.invoice.digit') }}"  value="{{ setting('sales-purchase-orders.sales_order.number_digit') }}" not-required />

                        <x-form.group.text name="number_next" label="{{ trans('settings.invoice.next') }}" value="{{ setting('sales-purchase-orders.sales_order.number_next') }}" not-required />

                        <x-form.group.select name="approval_terms" label="{{ trans('sales-purchase-orders::settings.sales_order.shipment_terms') }}" :options="$payment_terms" :selected="setting('sales-purchase-orders.sales_order.shipment_terms')" not-required />
                    </x-slot>
                </x-form.section>

                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head title=" {{ trans_choice('general.templates', 1) }}" description="{{ trans('sales-purchase-orders::settings.sales_order.form_description.template') }}" />
                    </x-slot>

                    <x-slot name="body">
                        <div class="sm:col-span-2 rounded-lg cursor-pointer text-center py-2 px-2">
                            <label class="cursor-pointer">
                                <div @click="form.template='default'">
                                    <img src="{{ asset('public/img/invoice_templates/default.png') }}" class="h-60 my-3" alt="Default" />
                                    <input type="radio" name="template" value="default" v-model="form._template">
                                    {{ trans('settings.invoice.default') }}
                                </div>
                            </label>
                        </div>

                        <div class="sm:col-span-2 rounded-lg cursor-pointer text-center py-2 px-2">
                            <label class="cursor-pointer">
                                <div @click="form.template='classic'">
                                    <img src="{{ asset('public/img/invoice_templates/classic.png') }}" class="h-60 my-3" alt="Classic" />
                                    <input type="radio" name="template" value="classic" v-model="form._template">
                                    {{ trans('settings.invoice.classic') }}
                                </div>
                            </label>
                        </div>

                        <div class="sm:col-span-2 rounded-lg cursor-pointer text-center py-2 px-2">
                            <label class="cursor-pointer">
                                <div @click="form.template='modern'">
                                    <img src="{{ asset('public/img/invoice_templates/modern.png') }}" class="h-60 my-3" alt="Modern" />
                                    <input type="radio" name="template" value="modern" v-model="form._template">
                                    {{ trans('settings.invoice.modern') }}
                                </div>
                            </label>
                        </div>

                        <x-form.group.color name="color" label="{{ trans('general.color') }}" />
                    </x-slot>
                </x-form.section>

                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head title="{{ trans_choice('general.defaults', 2) }}" description="{{ trans('sales-purchase-orders::settings.sales_order.form_description.default') }}" />
                    </x-slot>

                    <x-slot name="body">
                        <x-form.group.text name="title" label="{{ trans('settings.invoice.title') }}" value="{{ setting('sales-purchase-orders.sales_order.title') }}" not-required />

                        <x-form.group.text name="subheading" label="{{ trans('settings.invoice.subheading') }}" value="{{ setting('sales-purchase-orders.sales_order.subheading') }}" not-required />

                        <x-form.group.textarea name="notes" label="{{ trans_choice('general.notes', 2) }}" :value="setting('sales-purchase-orders.sales_order.notes')" form-group-class="sm:col-span-3" />

                        <x-form.group.textarea name="footer" label="{{ trans('general.footer') }}" :value="setting('sales-purchase-orders.sales_order.footer')" form-group-class="sm:col-span-3" />
                    </x-slot>
                </x-form.section>

                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head title="{{ trans_choice('settings.invoice.column', 2) }}" description="{{ trans('sales-purchase-orders::settings.sales_order.form_description.column') }}" />
                    </x-slot>

                    <x-slot name="body">
                        <div class="grid col-span-6 grid-rows-3">
                            <x-form.group.invoice-text
                                name="item_name"
                                label="{{ trans('settings.invoice.item_name') }}"
                                :options="$item_names"
                                :selected="setting('sales-purchase-orders.sales_order.item_name')"
                                change="settingsInvoice"
                                input-name="item_name_input"
                                :input-value="setting('sales-purchase-orders.sales_order.item_name_input')"
                                form-group-class="sm:col-span-6 sm:gap-0"
                            />

                            <x-form.group.invoice-text
                                name="price_name"
                                label="{{ trans('settings.invoice.price_name') }}"
                                :options="$price_names"
                                :selected="setting('sales-purchase-orders.sales_order.price_name')"
                                change="settingsInvoice"
                                input-name="price_name_input"
                                :input-value="setting('sales-purchase-orders.sales_order.price_name_input')"
                                form-group-class="sm:col-span-6 sm:gap-0"
                            />

                            <x-form.group.invoice-text
                                name="quantity_name"
                                label="{{ trans('settings.invoice.quantity_name') }}"
                                :options="$quantity_names"
                                :selected="setting('sales-purchase-orders.sales_order.quantity_name')"
                                change="settingsInvoice"
                                input-name="quantity_name_input"
                                :input-value="setting('sales-purchase-orders.sales_order.quantity_name_input')"
                                form-group-class="sm:col-span-6 sm:gap-0"
                            />
                        </div>

                        <x-form.group.toggle name="hide_item_description" label="{{ trans('settings.invoice.hide.item_description') }}" :value="setting('sales-purchase-orders.sales_order.hide_item_description')" not-required form-group-class="sm:col-span-6" />

                        <x-form.group.toggle name="hide_amount" label="{{ trans('settings.invoice.hide.amount') }}" :value="setting('sales-purchase-orders.sales_order.hide_amount')" not-required form-group-class="sm:col-span-6" />
                    </x-slot>
                </x-form.section>

                @can('update-estimates-settings-estimate')
                    <x-form.section>
                        <x-slot name="foot">
                            <x-form.buttons :cancel="url()->previous()" />
                        </x-slot>
                    </x-form.section>
                @endcan

                <x-form.input.hidden name="_template" :value="setting('sales-purchase-orders.sales_order.template')" />
                <x-form.input.hidden name="_prefix" value="sales-purchase-orders.sales_order" />
            </x-form>
        </x-form.container>
    </x-slot>

    <x-script folder="settings" file="settings" />
</x-layouts.admin>
