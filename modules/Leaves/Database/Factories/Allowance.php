<?php

namespace Modules\Leaves\Database\Factories;

use App\Abstracts\Factory;
use Illuminate\Support\Carbon;
use Modules\Leaves\Models\Allowance as Model;
use Modules\Leaves\Models\Entitlement;

class Allowance extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Model::class;

    public function definition(): array
    {
        if (!$entitlement = Entitlement::first()) {
            $entitlement = Entitlement::factory()->create();
        }

        $start_date = $this->faker->dateTimeInInterval($entitlement->policy->year->start_date, $entitlement->policy->year->end_date);
        $end_date = $this->faker->dateTimeInInterval($start_date, $entitlement->policy->year->end_date);

        return [
            'company_id'     => $this->company->id,
            'entitlement_id' => $entitlement->id,
            'employee_id'    => $entitlement->employee_id,
            'start_date'     => $start_date->format('Y-m-d'),
            'end_date'       => $end_date->format('Y-m-d'),
            'type'           => $this->faker->randomElement([Model::TYPE_ALLOWED, Model::TYPE_USED]),
            'days'           => Carbon::make($end_date)->diffInDays($start_date) + 1,
        ];
    }

    public function allowed(): Allowance
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => Model::TYPE_ALLOWED,
            ];
        });
    }

    public function used(): Allowance
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => Model::TYPE_USED,
            ];
        });
    }
}
