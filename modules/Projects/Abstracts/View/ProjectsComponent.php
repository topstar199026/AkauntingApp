<?php

namespace Modules\Projects\Abstracts\View;

use App\Abstracts\View\Component;

abstract class ProjectsComponent extends Component
{
    const RELATION = '';

    /** @var mixed */
    public $project;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(mixed $project = null, mixed $searchString = null) {
        if (! empty(static::RELATION) && is_null($searchString)) {
            $this->{static::RELATION} = $project->{static::RELATION}()->collect();
        } elseif (! is_null($searchString)) {
            $this->{static::RELATION} = $searchString;
        }

        $this->project = $project;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('projects::components.' . $this->getViewName());
    }

    public function getViewName(): string
    {
        $class = get_class($this);

        return strtolower(str_replace('Modules\Projects\View\Components\\', '', $class));
    }
}
