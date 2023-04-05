<?php

namespace Modules\Receipt\Listeners;

use App\Events\Module\Installed as Event;
use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use Artisan;

class ModuleInstalled
{
    public $company_id;

    /**
     * Handle the event.
     *
     * @param  Event $event
     *
     * @return void
     */
    public function handle(Event $event)
    {
        if ($event->alias != 'receipt') {
            return;
        }

        $this->company_id = $event->company_id;

        // Update permissions
        $this->updatePermissions();
    }

    protected function updatePermissions()
    {
        // Check if already exists
        if ($p = Permission::where('name', 'read-receipt-receipts')->value('id')) {
            return;
        }

        $permissions = [];

        $permissions[] = Permission::firstOrCreate([
                'name'         => 'create-receipt-receipts',
                'display_name' => 'Create Receipt',
                'description'  => 'Create Receipt',
        ]);

        $permissions[] = Permission::firstOrCreate([
                'name'         => 'read-receipt-receipts',
                'display_name' => 'Read Receipt',
                'description'  => 'Read Receipt',
        ]);

        $permissions[] = Permission::firstOrCreate([
                'name'         => 'update-receipt-receipts',
                'display_name' => 'Update Receipt',
                'description'  => 'Update Receipt',
        ]);

        $permissions[] = Permission::firstOrCreate([
                'name'         => 'delete-receipt-receipts',
                'display_name' => 'Delete Receipt',
                'description'  => 'Delete Receipt',
        ]);

        //Setting
        $permissions[] = Permission::firstOrCreate([
                'name'         => 'read-receipt-settings',
                'display_name' => 'Read Receipt Setting',
                'description'  => 'Read Receipt Setting',
        ]);

        $permissions[] = Permission::firstOrCreate([
                'name'         => 'update-receipt-settings',
                'display_name' => 'Update Receipt Setting',
                'description'  => 'Update Receipt Setting',
        ]);

        // Attach permission to roles
        $roles = Role::all()->filter(function ($r) {
            return $r->hasPermission('read-admin-panel');
        });

        foreach ($roles as $role) {
            /*$allowed = ['admin', 'manager'];

            if (!in_array($role->name, $allowed)) {
                continue;
            }*/

            foreach ($permissions as $permission) {
                if ($role->hasPermission($permission->name)) {
                    continue;
                }

                $role->attachPermission($permission);
            }
        }
    }
}
