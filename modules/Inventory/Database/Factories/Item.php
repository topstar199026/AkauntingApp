<?php

namespace Modules\Inventory\Database\Factories;

use App\Abstracts\Factory;
use Modules\Inventory\Models\Item as InventoryItem;

class Item extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InventoryItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $items[0] = [
            'opening_stock'         => $this->faker->randomNumber(3),
            'opening_stock_value'   => $this->faker->randomNumber(3),
            'reorder_level'         => $this->faker->randomNumber(3),
            'warehouse_id'          => setting('inventory.default_warehouse'),
            'default_warehouse'     => 'true',
            'created_from'          => 'inventory::factory',
        ];

        $units = [
            'box'       => trans('inventory::items.unit.box'),
            'dozen'     => trans('inventory::items.unit.dozen'),
            'grams'     => trans('inventory::items.unit.grams'),
            'kilograms' => trans('inventory::items.unit.kilograms'),
            'meters'    => trans('inventory::items.unit.meters'),
            'units'     => trans('inventory::items.unit.units'),
            'pairs'     => trans('inventory::items.unit.pairs'),
            'pieces'    => trans('inventory::items.unit.pieces'),
            'tablets'   => trans('inventory::items.unit.tablets')
        ];

        $types = ['product', 'service'];

        return [
            'company_id'            => $this->company->id,
            'type'                  => $this->faker->randomElement($types),
            'name'                  => $this->faker->text(15),
            'barcode'               => '',
            'sku'                   => $this->faker->text(5),
            'purchase_information'  => 1,
            'sale_information'      => 1,
            'purchase_price'        => $this->faker->randomFloat(2, 10, 20),
            'sale_price'            => $this->faker->randomFloat(2, 10, 20),
            'category_id'           => $this->company->categories()->item()->get()->random(1)->pluck('id')->first(),
            'description'           => $this->faker->text(20),
            'enabled'               => $this->faker->boolean ? 1 : 0,
            'track_inventory'       => true,
            'items'                 => $items,
            'unit'                  => $this->faker->randomElement($units),
            'created_from'          => 'inventory::factory',
        ];
    }

    /**
     * Indicate that the model is enabled.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function enabled()
    {
        return $this->state([
            'enabled' => '1',
        ]);
    }

    /**
     * Indicate that the model is disabled.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function disabled()
    {
        return $this->state([
            'enabled' => '0',
        ]);
    }
}
