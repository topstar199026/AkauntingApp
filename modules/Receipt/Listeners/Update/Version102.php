<?php

namespace Modules\Receipt\Listeners\Update;

use App\Events\Install\UpdateFinished;
use App\Abstracts\Listeners\Update as Listener;
use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use Illuminate\Support\Facades\Schema;

class Version102 extends Listener
{
    const ALIAS = 'receipt';

    const VERSION = '1.0.2';

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
        $this->deletePermission();
        $this->updatePermission();
    }

    public function updatePermission()
    {
         // Check if already exists
         if ($p = Permission::where('name', 'read-receipt-receipts')->value('id')) {
            return;
        }
        $permissions = [];

        $permissions[] = Permission::firstOrCreate(
            [
                'name'         => 'create-receipt-receipts',
                'display_name' => 'Create Receipt',
                'description'  => 'Create Receipt',
            ]
        );

        $permissions[] = Permission::firstOrCreate(
            [
                'name'         => 'read-receipt-receipts',
                'display_name' => 'Read Receipt',
                'description'  => 'Read Receipt',
            ]
        );

        $permissions[] = Permission::firstOrCreate(
            [
                'name'         => 'update-receipt-receipts',
                'display_name' => 'Update Receipt',
                'description'  => 'Update Receipt',
            ]
        );

        $permissions[] = Permission::firstOrCreate(
            [
                'name'         => 'delete-receipt-receipts',
                'display_name' => 'Delete Receipt',
                'description'  => 'Delete Receipt',
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
    public function deletePermission(){
        // Check if already exists
          Permission::where('name', 'read-receipt-receipt')->delete();
          Permission::where('name', 'create-receipt-receipt')->delete();
          Permission::where('name', 'update-receipt-receipt')->delete();
          Permission::where('name', 'delete-receipt-receipt')->delete();
    }
}
