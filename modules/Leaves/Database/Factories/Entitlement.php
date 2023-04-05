<?php

namespace Modules\Leaves\Database\Factories;

use App\Abstracts\Factory;
use Modules\Employees\Models\Employee;
use Modules\Leaves\Models\Entitlement as Model;
use Modules\Leaves\Models\Settings\Policy;

class Entitlement extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Model::class;

    public function definition(): array
    {
        if (!$policy_id = Policy::pluck('id')->first()) {
            $policy_id = Policy::factory()->create()->id;
        }

        if (!$employee_id = Employee::pluck('id')->first()) {
            $employee_id = Employee::factory()->create()->id;
        }

        return [
            'company_id'  => $this->company->id,
            'policy_id'   => $policy_id,
            'employee_id' => $employee_id,
        ];
    }
}
