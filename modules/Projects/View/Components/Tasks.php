<?php

namespace Modules\Projects\View\Components;

use Modules\Projects\Abstracts\View\ProjectsComponent;

class Tasks extends ProjectsComponent
{
    const RELATION = 'tasks';

    /** @var mixed */
    public $tasks;
}
