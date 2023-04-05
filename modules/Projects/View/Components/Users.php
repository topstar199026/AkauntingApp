<?php

namespace Modules\Projects\View\Components;

use Modules\Projects\Abstracts\View\ProjectsComponent;

class Users extends ProjectsComponent
{
    const RELATION = 'users';

    /** @var mixed */
    public $users;
}
