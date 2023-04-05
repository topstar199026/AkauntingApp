<?php

namespace Modules\Projects\View\Components;

use Modules\Projects\Abstracts\View\ProjectsComponent;

class Discussions extends ProjectsComponent
{
    const RELATION = 'discussions';

    /** @var mixed */
    public $discussions;
}
