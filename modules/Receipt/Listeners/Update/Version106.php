<?php

namespace Modules\Receipt\Listeners\Update;

use App\Events\Install\UpdateFinished;
use App\Abstracts\Listeners\Update as Listener;
use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use Illuminate\Support\Facades\Schema;

class Version106 extends Listener
{
    const ALIAS = 'receipt';

    const VERSION = '1.0.6';

    /**
     * Handle the event.
     *
     * @param  $event
     * @return void
     */
    public function handle(UpdateFinished $event)
    {
        // Check if should listen
        if (!$this->check($event)) {
            return;
        }
        $this->addPermission();
    }

    public function addPermission()
    {
         // Check if already exists
        if ($p = Permission::where('name', 'read-receipt-settings')->value('id')) {
            return;
        }
        $permissions = [];

        $permissions[] = Permission::firstOrCreate(
            [
                'name'         => 'create-receipt-settings',
                'display_name' => 'Create Receipt Setting',
                'description'  => 'Create Receipt Setting',
            ]
        );

        $permissions[] = Permission::firstOrCreate(
            [
                'name'         => 'read-receipt-settings',
                'display_name' => 'Read Receipt Setting',
                'description'  => 'Read Receipt Setting',
            ]
        );

        $permissions[] = Permission::firstOrCreate(
            [
                'name'         => 'update-receipt-settings',
                'display_name' => 'Update Receipt Setting',
                'description'  => 'Update Receipt Setting',
            ]
        );

        $permissions[] = Permission::firstOrCreate(
            [
                'name'         => 'delete-receipt-settings',
                'display_name' => 'Delete Receipt Setting',
                'description'  => 'Delete Receipt Setting',
            ]
        );

        // Attach permission to roles
        $roles = Role::all();

        foreach ($roles as $role) {
            $allowed = ['admin', 'manager'];

            if (!in_array($role->name, $allowed)) {
                continue;
            }

            foreach ($permissions as $permission) {
                $role->attachPermission($permission);
            }
        }
    }
}
