<?php

namespace Modules\Leaves\Database\Factories;

use App\Abstracts\Factory;
use Modules\Leaves\Models\Settings\LeaveType as Model;

class LeaveType extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Model::class;

    public function definition(): array
    {
        return [
            'company_id'  => $this->company->id,
            'name'        => ucfirst($this->faker->word) . ' Leave Type',
            'description' => $this->faker->sentence,
        ];
    }
}
