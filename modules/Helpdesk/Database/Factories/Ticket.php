<?php

namespace Modules\Helpdesk\Database\Factories;

use App\Abstracts\Factory;
use Modules\Helpdesk\Models\Ticket as Model;

class Ticket extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Model::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => $this->company->id,
            'subject' => $this->faker->text(15),
            'message' => $this->faker->text(100),
            'category_id' => $this->company->categories()->type(['ticket'])->get()->random(1)->pluck('id')->first(),
            'status_id' => 1,
            'priority_id' => 1,
            'assignee_id' => 1,
        ];
    }
}
