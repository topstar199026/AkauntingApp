<?php

namespace Modules\Projects\View\Components;

use Modules\Projects\Abstracts\View\ProjectsComponent;

class Milestones extends ProjectsComponent
{
    const RELATION = 'milestones';

    /** @var mixed */
    public $milestones;
}
