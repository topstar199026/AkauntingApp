<?php

namespace Modules\Projects\Database\Seeds;

use App\Abstracts\Model;
use App\Traits\Permissions as Helper;
use Illuminate\Database\Seeder;

class Permissions extends Seeder
{
    use Helper;

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
            'projects-projects' => 'c,r,u,d',
            'projects-tasks' => 'c,r,u,d',
            'projects-timesheets' => 'c,r,u,d',
            'projects-milestones' => 'c,r,u,d',
            'projects-activities' => 'r',
            'projects-transactions' => 'r',
            'projects-discussions' => 'c,r,u,d',
            'projects-comments' => 'c',
            'projects-discussion-likes' => 'c,d',
            'projects-invoices' => 'c',
        ]);

        $this->attachPermissionsToPortalRoles([
            'projects-portal-projects' => 'r',
            'projects-portal-tasks' => 'c,r',
            'projects-portal-timesheets' => 'r',
            'projects-portal-milestones' => 'r',
            'projects-portal-activities' => 'r',
            'projects-portal-transactions' => 'r',
            'projects-portal-discussions' => 'c,r',
            'projects-portal-comments' => 'c',
            'projects-portal-discussion-likes' => 'c,d',
        ]);
    }
}
