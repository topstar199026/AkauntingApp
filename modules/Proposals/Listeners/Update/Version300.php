<?php

namespace Modules\Proposals\Listeners\Update;

use App\Abstracts\Listeners\Update as Listener;
use App\Events\Install\UpdateFinished;
use App\Traits\Permissions;
use Illuminate\Support\Facades\File;

class Version300 extends Listener
{
    use Permissions;

    const ALIAS = 'proposals';

    const VERSION = '3.0.0';

    /**
     * Handle the event.
     *
     * @param  $event
     * @return void
     */
    public function handle(UpdateFinished $event)
    {
        if ($this->skipThisUpdate($event)) {
            return;
        }

        $this->detachPermissionsFromPortalRoles([
            'portal-proposals' => 'r,u',
        ]);

        File::delete(base_path('modules/Proposals/Resources/assets/img/proposals.png'));
        File::delete(base_path('modules/Proposals/Resources/assets/img/templates.png'));
    }
}
