<?php

namespace Modules\Leaves\Database\Seeds;

use App\Abstracts\Model;
use App\Traits\Permissions as Helper;
use Illuminate\Database\Seeder;

class Permissions extends Seeder
{
    use Helper;

    const ALIAS = 'leaves';

    public function run()
    {
        Model::unguard();

        $this->create();

        Model::reguard();
    }

    private function create()
    {
        $this->attachPermissionsToAdminRoles([
            self::ALIAS . '-main'         => 'r',
            self::ALIAS . '-entitlements' => 'c,r,d',
            self::ALIAS . '-calendar'     => 'r',
            self::ALIAS . '-settings'     => 'r,u',
            self::ALIAS . '-leaves'       => 'c,d',
        ]);
    }
}
