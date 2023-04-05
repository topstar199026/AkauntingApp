<?php

namespace Modules\Calendar\Events;

use App\Abstracts\Event;

class CalendarEventCreated extends Event
{
    public $calendar;

    /**
     * Create a new event instance.
     *
     * @param $modules
     */
    public function __construct($calendar)
    {
        $this->calendar = $calendar;
    }
}