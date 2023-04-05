<?php

namespace Modules\Helpdesk\Database\Factories;

use App\Abstracts\Factory;
use Modules\Helpdesk\Models\Reply as Model;
use Modules\Helpdesk\Models\Ticket;

class Reply extends Factory
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
            'ticket_id' => Ticket::get()->random(1)->pluck('id')->first(),
            'message' => $this->faker->text(100),
            'internal' => $this->faker->boolean ? 1 : 0,
        ];
    }
}
