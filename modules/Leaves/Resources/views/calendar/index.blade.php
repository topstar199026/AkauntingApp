<x-layouts.admin>
    <x-slot name="title">
        {{ trans('leaves::general.calendar') }}
    </x-slot>

    <x-slot name="favorite"
        :title="trans('leaves::general.calendar')"
        icon="custom-calendar_month_24dp"
        route="leaves.calendar.index">
    </x-slot>

    <x-slot name="content">
        <div class="mt-6 mb-4">
            <full-calendar
                ref="fullCalendar"
                class="calendar"
                :options="calendarOptions"
            />
        </div>

        <akaunting-modal
            :show="leave_show.modal"
            @cancel="leave_show.modal = false"
            :title="'{{ trans('leaves::calendar.leave_details') }}'"
            :button_delete="'{{ trans('general.button.cancel') }}'"
            :message="leave_show.html">
            <template #modal-body>
                <div class="grid grid-cols-2 px-5 bg-body gap-y-4">
                    <div>{{ trans_choice('employees::general.employees', 1) }}:</div>
                    <div>
                        <a :href="event.extendedProps.employee_route" class="font-bold">@{{ event.extendedProps.employee }}</a>
                    </div>
                    <div>{{ trans('leaves::general.leave_policy') }}:</div>
                    <div>
                        <a :href="event.extendedProps.policy_route" class="font-bold">@{{ event.extendedProps.policy }}</a>
                    </div>
                    <div>{{ trans('general.start_date') }}:</div>
                    <div>
                        <span class="font-bold">@{{ event.extendedProps.start_date }}</span>
                    </div>
                    <div>{{ trans('general.end_date') }}:</div>
                    <div>
                        <span class="font-bold">@{{ event.extendedProps.end_date }}</span>
                    </div>
                    <div>{{ trans_choice('leaves::allowances.days', 2) }}:</div>
                    <div>
                        <span class="font-bold">@{{ event.extendedProps.days }}</span>
                    </div>
                </div>
            </template>

            <template #card-footer>
                <div class="flex items-center justify-end">
                    <button :disabled="deleting" type="button" class="relative flex items-center justify-center bg-red hover:bg-red-700  px-6 py-1.5 text-base rounded-lg disabled:opacity-50 text-white" @click="deleteEvent">
                        <div class="aka-loader"></div><span>{{ trans('general.delete') }}</span>
                    </button>
                </div>
            </template>
        </akaunting-modal>
    </x-slot>

    @push('stylesheet')
        <link rel="stylesheet" href="{{ asset('modules/Leaves/Resources/assets/css/calendar.css?v=' . module_version('leaves')) }}" type="text/css">
    @endpush

    @push('scripts_start')
        <script type="text/javascript">
            if ({!! json_encode($leaves) !!} == null) {
                var events = [];
            } else {
                var events = {!! json_encode($leaves) !!};
            }
            var calendar_first = '{{ setting('calendar.first_day') }}';
            var calendar_locale = '{{ strtolower(language()->getShortCode()) }}';
            var calendar_country = '{{ setting('company.country', 'GB') }}';
            var calendar_holiday_enabled = '{{ setting('calendar.holidays.enabled', '0') }}';
            var create_route = '{{ route('leaves.modals.leaves.create') }}';
        </script>
    @endpush

    <x-script
        alias="leaves"
        file="calendar/index"
    />
</x-layouts.admin>
