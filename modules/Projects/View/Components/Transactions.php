<?php

namespace Modules\Projects\View\Components;

use Modules\Projects\Abstracts\View\ProjectsComponent;

class Transactions extends ProjectsComponent
{
    const RELATION = 'transactions';

    /** @var mixed */
    public $transactions;
}
