<x-layouts.admin>
    <x-slot name="title">{{ trans('calendar::general.name') }}</x-slot>

    <x-slot name="favorite"
        title="{{ trans('calendar::general.name') }}"
        icon="custom-calendar_month_24dp"
        route="calendar.index"
    ></x-slot>

    <x-slot name="content">
        <div class="mt-6 mb-4">
            <full-calendar class="calendar" ref="fullCalendar" :options="calendarOptions" />
        </div>

        <akaunting-modal
            :show="calendar.modal"
            @cancel="calendar.modal = false"
            title="{{ trans('general.add_new') }}">
            <template #modal-body>
                @include('calendar::modals.rotation')
            </template>

            <template #card-footer>
                <div class="float-right"></div>
            </template>
        </akaunting-modal>

        <akaunting-modal
            :show="event_show.modal"
            @cancel="event_show.modal = false"
            :title="event_show.event.title">
            <template #modal-body>
                @include('calendar::modals.show')
            </template>

            <template #card-footer>
                <div class="float-right"></div>
            </template>
        </akaunting-modal>

        <el-popover
            class="holiday-popover"
            v-model="holiday_show.modal"
            :title="holiday_show.message"
            placement="bottom">
            <label v-text="holiday_show.title"></label>

            <button type="button" class="mt-3 close" @click="holiday_show.modal = false" aria-hidden="true">&times;</button>
        </el-popover>
    </x-slot>

    @push('stylesheet')
        <link href="{{ asset('modules/Calendar/Resources/assets/css/custom.css?v=' . module_version('calendar')) }}" rel="stylesheet">

        <link href="{{ asset('modules/Calendar/Resources/assets/css/calendar.css?v=' . module_version('calendar')) }}" rel="stylesheet">
    @endpush

    @push('scripts_start')
        <script type="text/javascript">
            if ({!! json_encode($events) !!} == null) {
                var events = [];
            } else {
                var events = {!! json_encode($events) !!};
            }

            var calendar_first = '{{ setting('calendar.first_day') }}';
            var calendar_locale = '{{ strtolower(language()->getShortCode()) }}';
            var calendar_country = '{{ setting('company.country', 'GB') }}';
            var calendar_holiday_enabled = '{{ setting('calendar.holidays.enabled', '0') }}';
        </script>
    @endpush

    <x-script alias="calendar" file="calendar" />
</x-layouts.admin>
