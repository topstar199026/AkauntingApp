<?php

namespace Modules\Projects\View\Components;

use Modules\Projects\Abstracts\View\ProjectsComponent;

class Activities extends ProjectsComponent
{
    /** @var mixed */
    public $activities;

    /** @var mixed */
    public $project;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(mixed $project = null) {
        $this->activities = $project->activities()->orderBy('created_at', 'DESC')->collect();

        $this->project = $project;
    }
}
