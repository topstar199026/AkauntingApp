<?php
namespace Modules\Mt940\Listeners;

use App\Events\Module\Installed as Event;
use App\Models\Auth\Permission;
use App\Models\Auth\Role;

class ModuleInstalled
{

    /**
     * Handle the event.
     *
     * @param Event $event
     *
     * @return void
     */
    public function handle(Event $event)
    {
        if ($event->alias != 'mt940') {
            return;
        }

        // Update permissions
        $this->updatePermissions();
    }

    protected function updatePermissions()
    {
        // Check if already exists
        if ($p = Permission::where('name', 'read-mt940')->pluck('id')->first()) {
            return;
        }

        $permissions = [];

        $permissions[] = Permission::firstOrCreate([
            'name' => 'read-mt940',
            'display_name' => 'Read Mt940',
            'description' => 'Read Mt940'
        ]);

        // Attach permission to roles
        $roles = Role::all();

        foreach ($roles as $role) {
            $allowed = [
                'admin',
                'manager'
            ];

            if (! in_array($role->name, $allowed)) {
                continue;
            }

            foreach ($permissions as $permission) {
                $role->attachPermission($permission);
            }
        }
    }
}