<?php

namespace Modules\Leaves\Database\Factories;

use App\Abstracts\Factory;
use Modules\Employees\Models\Department;
use Modules\Leaves\Models\Employee;
use Modules\Leaves\Models\Settings\LeaveType;
use Modules\Leaves\Models\Settings\Policy as Model;
use Modules\Leaves\Models\Settings\Year;

class Policy extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Model::class;

    public function definition(): array
    {
        if (!$leave_type_id = LeaveType::pluck('id')->first()) {
            $leave_type_id = LeaveType::factory()->create()->id;
        }

        if (!$year_id = Year::pluck('id')->first()) {
            $year_id = Year::factory()->create()->id;
        }

        if (!$department_id = Department::enabled()->pluck('id')->first()) {
            $department_id = Department::factory()->enabled()->create()->id;
        }

        return [
            'company_id'       => $this->company->id,
            'leave_type_id'    => $leave_type_id,
            'year_id'          => $year_id,
            'department_id'      => $department_id,
            'name'             => ucfirst($this->faker->word) . ' Leave Policy',
            'contract_type'    => $this->faker->randomElement(['full-time', 'part-time']),
            'gender'           => $this->faker->randomElement(array_keys(Employee::getAvailableGenders())),
            'days'             => $this->faker->numberBetween(1, 366),
            'applicable_after' => $this->faker->numberBetween(1, 366),
            'carryover_days'   => $this->faker->numberBetween(1, 366),
            'is_paid'          => $this->faker->randomElement([0, 1]),
        ];
    }
}
