<?php

namespace Modules\Calendar\Widgets;

use App\Abstracts\Widget;

class Calendar extends Widget
{
    public $default_name = 'calendar::general.name';

    public function show()
    {
        return $this->view('calendar::widgets.calendar');
    }
}
