<?php

namespace Modules\Proposals\Database\Seeds;

use App\Abstracts\Model;
use Illuminate\Database\Seeder;
use Modules\Crm\Models\DealPipeline;
use Modules\Proposals\Models\ProposalPipeline;

class Pipelines extends Seeder
{
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
        if (!module('crm')) {
            return;
        }

        $company_id = $this->command->argument('company');

        $pipelines = DealPipeline::companyId($company_id)->get();

        foreach ($pipelines as $pipeline) {
            ProposalPipeline::create(
                [
                    'company_id'    => $company_id,
                    'pipeline_id'   => $pipeline->id,
                ]
            );
        }
    }
}
