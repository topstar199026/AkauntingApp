<?php

namespace Modules\Helpdesk\Listeners;

use App\Events\Module\Installed as Event;
use App\Traits\Permissions;
use Artisan;

class FinishInstallation
{
    use Permissions;

    public $alias = 'helpdesk';

    /**
     * Handle the event.
     *
     * @param  Event $event
     * @return void
     */
    public function handle(Event $event)
    {
        if ($event->alias != $this->alias) {
            return;
        }

        $this->updatePermissions();

        $this->createTicketNextSetting();

        $this->callSeeds();
    }

    protected function updatePermissions()
    {
        // c=create, r=read, u=update, d=delete
        $this->attachPermissionsToAdminRoles([
            $this->alias . '-tickets' => 'c,r,u,d',
            $this->alias . '-replies' => 'c,r,u,d',
            $this->alias . '-statuses' => 'r',
        ]);

        // c=create, r=read, u=update, d=delete
        $this->attachPermissionsToPortalRoles([
            $this->alias . '-portal-tickets' => 'c,r',
            $this->alias . '-portal-replies' => 'c,r',
            $this->alias . '-portal-statuses' => 'r',
        ]);
    }

    protected function createTicketNextSetting()
    {
        if (setting('helpdesk.tickets.next') == null) {
            setting([
                'helpdesk.tickets.next' => 1 // First ticket
            ])->save();
        }
    }

    protected function callSeeds()
    {
        Artisan::call('company:seed', [
            'company' => company_id(),
            '--class' => 'Modules\Helpdesk\Database\Seeds\HelpdeskDatabaseSeeder',
        ]);
    }
}
