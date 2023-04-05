<x-layouts.admin>
    <x-slot name="title">{{ trans('general.title.new', ['type' => trans_choice('appointments::general.appointments', 1)]) }}</x-slot>

    <x-slot name="favorite"
        title="{{ trans('general.title.new', ['type' => trans_choice('appointments::general.appointments', 1)]) }}"
        icon="today"
        route="appointments.appointments.create"
    ></x-slot>

    <x-slot name="content">
        <x-form.container>
            <x-form id="appointment" route="appointments.appointments.store">
                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head title="{{ trans('general.general') }}" />
                    </x-slot>

                    <x-slot name="body">
                        <x-form.group.text name="appointment_name" label="{{ trans('appointments::general.appointment_name') }}" />

                        <x-form.group.select multiple name="question_ids" label="{{ trans_choice('appointments::general.questions', 2) }}" :options="$questions" not-required form-group-class="sm:col-span-3 el-select-tags-pl-38" />

                        <x-form.group.select name="owner" label="{{ trans('appointments::general.owner') }}" :options="$owner" change="onSelectUser" form-group-class="sm:col-span-3" />

                        <x-form.group.select name="appointment_type" label="{{ trans('appointments::general.appointment_type') }}" :options="$appointment_type" change="onSelectType" form-group-class="sm:col-span-3" />

                        <x-form.group.select multiple name="week_days" label="{{ trans('appointments::general.week_day') }}" v-show="manager_select" :options="$week_days" :selected="old('week_days', json_decode(setting('appointments.week_days', '')))" form-group-class="sm:col-span-3 el-select-tags-pl-38" />
                        
                        <x-form.group.time name="starting_time" label="{{ trans('appointments::general.starting_time') }}" v-show="manager_select" id="starting_time" :value="old('starting_time', setting('appointments.starting_time'))" time_24hr=true autocomplete="off" />

                        <x-form.group.time name="ending_time" label="{{ trans('appointments::general.ending_time') }}" v-show="manager_select" id="ending_time" :value="old('ending_time', setting('appointments.ending_time'))" time_24hr=true autocomplete="off" />

                        <x-form.group.money name="amount" label="{{ trans('general.amount') }}" v-show="type_select" value="0" :currency="$currency" dynamicCurrency="currency" />

                        <x-form.input.hidden name="enabled" value=1 />
                    </x-slot>
                </x-form.section>

                <div class="border-b-2 border-gray-200 mb-10 pb-4" x-data="{create:null}">
                    <button type="button" class="relative w-full text-left cursor-pointer" x-on:click="create !== 1 ? create = 1 : create = null">
                        <span class="font-medium">{{ trans('appointments::general.scheduling') }}</span>
                        <span class="material-icons absolute right-0 top-0 transition-all transform" x-bind:class="create === 1 ? 'rotate-180' : ''">expand_more</span>
                    </button>
            
                    <div class="relative overflow-hidden transition-all max-h-0 duration-700 mt-3" style="" x-ref="container1" x-bind:style="create == 1 ? 'max-height: ' + $refs.container1.scrollHeight + 'px' : ''">
                        <x-form.section>
                            <x-slot name="body">
                                <x-form.group.time name="appointment_duration" label="{{ trans('appointments::general.appointment_duration') }}" id="appointment_duration" :value="old('appointment_duration', setting('appointments.appointment_duration'))" time_24hr=true autocomplete="off" />

                                <x-form.group.select name="reminders" label="{{ trans('appointments::general.reminders') }}" :options="$reminders" :selected="old('reminders', setting('appointments.reminders'))" form-group-class="sm:col-span-3" />

                                <x-form.group.number name="before_schedule_appointment" label="{{ trans('appointments::general.before_schedule_appointment') }}" :value="old('before_schedule_appointment', setting('appointments.before_schedule_appointment'))" max=24 />

                                <x-form.group.number name="after_schedule_appointment" label="{{ trans('appointments::general.after_schedule_appointment') }}" :value="old('after_schedule_appointment', setting('appointments.after_schedule_appointment'))" max=30 />

                                <x-form.group.number name="allow_cancelled" label="{{ trans('appointments::general.allow_cancelled') }}" :value="old('allow_cancelled', setting('appointments.allow_cancelled'))" max=24 />

                                <x-form.group.select name="recurring" label="{{ trans('recurring.recurring') }}" :options="$recurring" :selected="old('recurring', setting('appointments.recurring'))" form-group-class="sm:col-span-3" />

                                <x-form.group.toggle name="approval_control" label="{{ trans('appointments::general.approval_control') }}" :value="old('approval_control', setting('appointments.approval_control'))" not-required form-group-class="sm:col-span-6" />
                            </x-slot>
                        </x-form.section>
                    </div>
                </div>

                <div class="border-b-2 border-gray-200 mb-10 pb-4" v-if="employees_select" x-data="{create:null}">
                    <button type="button" class="relative w-full text-left cursor-pointer" x-on:click="create !== 1 ? create = 1 : create = null">
                        <span class="font-medium">{{ trans('employees::general.name') }}</span>
                        <span class="material-icons absolute right-0 top-0 transition-all transform" x-bind:class="create === 1 ? 'rotate-180' : ''">expand_more</span>
                    </button>
            
                    <div class="relative overflow-hidden transition-all max-h-0 duration-700 mt-3" style="" x-ref="container1" x-bind:style="create == 1 ? 'max-height: ' + $refs.container1.scrollHeight + 'px' : ''">
                        <x-table>
                            <x-table.thead>
                                <x-table.tr class="flex items-center px-1">
                                    <x-table.th class="w-2/12 hidden sm:table-cell">
                                        {{ trans_choice('employees::general.employees', 1) }}
                                    </x-table.th>
                        
                                    <x-table.th class="w-3/12 hidden text-center sm:table-cell">
                                        {{ trans('appointments::general.week_day') }}
                                    </x-table.th>
                        
                                    <x-table.th class="w-3/12 hidden text-center sm:table-cell">
                                        {{ trans('appointments::general.starting_time') }}
                                    </x-table.th>

                                    <x-table.th class="w-4/12 hidden text-center sm:table-cell">
                                        {{ trans('appointments::general.ending_time') }}
                                    </x-table.th>
                                </x-table.tr>
                            </x-table.thead>
                        
                            <x-table.tbody>
                                <x-table.tr data-table-list class="relative flex items-center border-b hover:bg-gray-100 px-1 group" v-for="(row, index) in form.items" ::index="index">
                                    <x-table.td class="w-2/12 hidden sm:table-cell">
                                        <akaunting-select
                                            class="form-element-sm d-inline-block col-md-12"
                                            :placeholder="'{{ trans('general.form.select.field', ['field' => trans_choice('employees::general.employees', 1)]) }}'"
                                            :name="'contact_id'"
                                            v-model="row.contact_id"
                                            :options="{{ json_encode($employees) }}"
                                            :value="'{{ old('contact_id') }}'"
                                            @interface="row.contact_id = $event"
                                        >
                                        </akaunting-select>
                                    </x-table.td>
                        
                                    <x-table.td class="w-3/12 hidden sm:table-cell">
                                        <x-form.group.select multiple name="week_days" :options="$week_days" :selected="old('week_days', json_decode(setting('appointments.week_days', '')))" v-model="row.week_days" form-group-class="sm:col-span-3 el-select-tags-pl-38" />
                                    </x-table.td>
                        
                                    <x-table.td class="w-3/12 hidden sm:table-cell">
                                        <x-form.group.time name="starting_time" label="{{ trans('appointments::general.starting_time') }}" id="starting_time" :value="old('starting_time', setting('appointments.starting_time'))" v-model="row.starting_time" time_24hr=true autocomplete="off" />
                                    </x-table.td>

                                    <x-table.td class="w-3/12 hidden sm:table-cell">
                                        <x-form.group.time name="ending_time" label="{{ trans('appointments::general.ending_time') }}" id="ending_time" :value="old('ending_time', setting('appointments.ending_time'))" v-model="row.ending_time" time_24hr=true autocomplete="off" />
                                        <x-form.input.hidden name="hidden" value=hidden />
                                    </x-table.td>
                        
                                    <x-table.td class="w-1/12 hidden sm:table-cell none-truncate" override="class">
                                        <x-button type="button" @click="onDeleteItem(index)" class="px-3 py-1.5 mb-3 sm:mt-2 sm:mb-0 rounded-xl text-sm font-medium leading-6 hover:bg-gray-200 disabled:bg-gray-50" override="class">
                                            <span class="w-full material-icons-outlined text-lg text-gray-300 group-hover:text-gray-500">delete</span>
                                        </x-button>
                                    </x-table.td>
                                </x-table.tr>
                        
                                <x-table.tr id="addItem">
                                    <x-table.td class="w-full hidden sm:table-cell">
                                        <x-button type="button" override="class" @click="onAddItem" class="w-full text-secondary flex items-center justify-center" title="{{ trans('general.add') }}">
                                            <span class="material-icons-outlined text-base font-bold mr-1">add</span>
                                            {{ trans('general.form.add', ['field' => trans_choice('employees::general.employees', 1)]) }}
                                        </x-button>
                                    </x-table.td>
                                </x-table.tr>
                            </x-table.tbody>
                        </x-table>
                    </div>
                </div>

                <x-form.section>
                    <x-slot name="foot">
                        <x-form.buttons cancel-route="appointments.appointments.index" />
                    </x-slot>
                </x-form.section>
            </x-form> 
        </x-form.container>
    </x-slot>

    @push('scripts_start')
        <script type="text/javascript">
            var events = [];
            var calendar_locale = '{{ strtolower(language()->getShortCode()) }}';
            var calendar_country = '{{ setting('company.country', 'GB') }}';
        </script>
    @endpush

    <x-script alias="appointments" file="appointments" />
</x-layouts.admin>