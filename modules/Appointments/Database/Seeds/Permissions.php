<?php

namespace Modules\Appointments\Database\Seeds;

use App\Abstracts\Model;
use App\Traits\Permissions as Helper;
use Illuminate\Database\Seeder;

class Permissions extends Seeder
{
    use Helper;

    public $alias = 'appointments';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->create();

        Model::reguard();
    }

    private function create()
    {
        $this->attachPermissionsToAdminRoles([
            $this->alias . '-appointments' => 'c,r,u,d',
            $this->alias . '-questions' => 'c,r,u,d',
            $this->alias . '-scheduled' => 'c,r,u,d',
            $this->alias . '-settings' => 'r,u',
        ]);

        $this->attachPermissionsToPortalRoles([
            $this->alias . '-portal-appointments' => 'c,r,u,d',
            $this->alias . '-portal-scheduled' => 'c,r,u,d',
        ]);
    }
}
