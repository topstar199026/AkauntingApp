<?php

namespace Modules\Helpdesk\Database\Seeds;

use App\Abstracts\Model;
use Illuminate\Database\Seeder;
use App\Jobs\Setting\CreateCategory;
use App\Traits\Jobs;

class Categories extends Seeder
{
    use Jobs;

    public function run()
    {
        Model::unguard();

        $this->create();

        Model::reguard();
    }

    private function create()
    {
        $company_id = $this->command->argument('company');

        $categories = [
            [
                'company_id' => $company_id,
                'name' => trans('helpdesk::general._category.change_request'),
                'type' => 'ticket',
                'color' => '#7f557d',
                'enabled' => '1',
            ],
            [
                'company_id' => $company_id,
                'name' => trans('helpdesk::general._category.incident'),
                'type' => 'ticket',
                'color' => '#726e97',
                'enabled' => '1',
            ],
            [
                'company_id' => $company_id,
                'name' => trans('helpdesk::general._category.problem'),
                'type' => 'ticket',
                'color' => '#7698b3',
                'enabled' => '1',
            ],
            [
                'company_id' => $company_id,
                'name' => trans('helpdesk::general._category.feature_request'),
                'type' => 'ticket',
                'color' => '#83b5d1',
                'enabled' => '1',
            ],
        ];

        foreach ($categories as $category) {
            $category['created_from'] = 'helpdesk::seed';

            $this->dispatch(new CreateCategory($category));
        }
    }
}
