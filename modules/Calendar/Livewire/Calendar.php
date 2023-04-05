<?php

namespace Modules\Calendar\Livewire;

use Livewire\Component;
use Modules\Calendar\Events\CalendarEventCreated;

class Calendar extends Component
{
    public $name = 'Barry';

    public $events = [];

    public function render()
    {
        event(new CalendarEventCreated($data = new \stdClass()));

        $this->events = $data->events ?? null;

        if (empty($this->events[0])) {
            $this->events = null;
        }

        return view('calendar::livewire.calendar');
    }
}
