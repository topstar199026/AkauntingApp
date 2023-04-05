<?php

namespace Modules\Leaves\Database\Factories;

use App\Abstracts\Factory;
use Modules\Leaves\Models\Settings\Year as Model;

class Year extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Model::class;

    public function definition(): array
    {
        $start_date = $this->faker->dateTimeInInterval('-1 year', '+1 year');
        $end_date = $this->faker->dateTimeInInterval($start_date, '+5 years');

        return [
            'company_id' => $this->company->id,
            'name'       => ucfirst($this->faker->word) . ' Leave Year',
            'start_date' => $start_date->format('Y-m-d'),
            'end_date'   => $end_date->format('Y-m-d'),
        ];
    }
}
