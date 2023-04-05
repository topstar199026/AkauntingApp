<?php

namespace Modules\Leaves\Listeners;

use App\Traits\Modules;
use Modules\Employees\Events\AddingHRDropdown;

class ShowHRDropdown
{
    use Modules;

    public function handle(AddingHRDropdown $event)
    {
        if ($this->moduleIsDisabled('leaves')) {
            return;
        }

        if (user()->canAny([
            'read-leaves-main',
            'read-leaves-entitlements',
            'read-leaves-calendar',
        ])) {
            $event->show_dropdown = true;

            return false;
        }
    }
}
