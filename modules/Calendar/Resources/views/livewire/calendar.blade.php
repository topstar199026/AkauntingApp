<div>
    <div id='calendar-container' wire:ignore>
        <div id='calendar'></div>
    </div>
</div>

@push('scripts')
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

        document.addEventListener('livewire:load', function() {
            // initialize the calendar
            // -----------------------------------------------------------------
            new FullCalendar.Calendar(document.getElementById('calendar'), {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: '{{ trans('calendar::general.today') }}',
                    month: '{{ trans('calendar::general.month') }}',
                    week: '{{ trans('calendar::general.week') }}',
                    day: '{{ trans('calendar::general.day') }}',
                    list: '{{ trans('calendar::general.list') }}',
                },
                dayMaxEventRows: true,
                views: {
                    timeGrid: {
                        dayMaxEventRows: 3
                    }
                },
                dayPopoverFormat: function(date) {
                    return arguments[0].date.marker.toLocaleDateString('en-GB',{day: '2-digit', month: 'short', year: 'numeric'});
                },
                eventClick: function(data) {
                    if (data.event.extendedProps.type == 'holiday') {
                        return;
                    }
                    window.location.href = data.event.extendedProps.show;
                },
                locale:"{{ strtolower(language()->getShortCode()) }}",
                editable: false,
                events: events
            }).render();
        });
    </script>

    <script src="{{ asset('modules/Calendar/Resources/assets/js/main.min.js?v=' . module_version('calendar')) }}"></script>
    <script src="{{ asset('modules/Calendar/Resources/assets/js/calendar.min.js?v=' . module_version('calendar')) }}"></script>

    <link href="{{ asset('modules/Calendar/Resources/assets/css/custom.css?v=' . module_version('calendar')) }}" rel='stylesheet' />
    <link href="{{ asset('modules/Calendar/Resources/assets/css/main.min.css?v=' . module_version('calendar')) }}" rel='stylesheet' />

    <style>
        .g-sidenav-hidden .fc-col-header, .g-sidenav-hidden .fc-daygrid-body, .g-sidenav-hidden .fc-scrollgrid-sync-table  {
            width: 100% !important;
        }
        .g-sidenav-show .fc-col-header, .g-sidenav-show .fc-daygrid-body, .g-sidenav-show .fc-scrollgrid-sync-table  {
            width: 100% !important;
        }
    </style>
@endpush
