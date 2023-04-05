<?php

namespace Modules\Proposals\Database\Seeds;

use App\Abstracts\Model;
use App\Traits\Permissions as Helper;
use Illuminate\Database\Seeder;

class Permissions extends Seeder
{
    use Helper;

    public $alias = 'proposals';

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
            'proposals-proposals' => 'c,r,u,d',
            'proposals-templates' => 'c,r,u,d',
            'proposals-pipelines' => 'r,u',
        ]);

        $this->attachPermissionsToPortalRoles([
            'proposals-portal-proposals' => 'r,u',
        ]);
    }
}
