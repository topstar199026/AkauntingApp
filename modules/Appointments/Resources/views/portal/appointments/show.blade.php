<x-layouts.portal>
    <x-slot name="title">{{ $appointment->appointment_name }}</x-slot>

    <x-slot name="content">
        <div class="mt-6 mb-4">
            <full-calendar class="calendar" ref="fullCalendar" :options="calendarOptions" />
        </div>
    </x-slot>

    @push('scripts_start')
        <script type="text/javascript">
            if ({!! json_encode($events) !!} == null) {
                var events = [];
            } else {
                var events = {!! json_encode($events) !!};
            }

            var calendar_locale = '{{ strtolower(language()->getShortCode()) }}';
            var calendar_country = '{{ setting('company.country', 'GB') }}';
        </script>
    @endpush

    @push('content_content_end')
        <component v-bind:is="dynamic_component"></component>
    @endpush

    @push('stylesheet')
        <link href="{{ asset('modules/Appointments/Resources/assets/css/custom.css?v=' . module_version('appointments')) }}" rel="stylesheet" />

        <link rel="stylesheet" href="{{ asset('modules/Appointments/Resources/assets/css/calendar.css?v=' . module_version('appointments')) }}" type="text/css">
    @endpush

    <x-script alias="appointments" file="portal" />
</x-layouts.portal>