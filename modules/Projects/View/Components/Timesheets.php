<?php

namespace Modules\Projects\View\Components;

use Modules\Projects\Abstracts\View\ProjectsComponent;

class Timesheets extends ProjectsComponent
{
    const RELATION = 'timesheets';

    /** @var mixed */
    public $timesheets;
}
