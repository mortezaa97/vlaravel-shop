<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Mortezaa97\Shop\Models\Attribute;
use Mortezaa97\Shop\Models\AttributeValue;
use Mortezaa97\Shop\Models\Product;
use Mortezaa97\Shop\Models\Specification;

/**
 * @extends Factory<Specification>
 */
class SpecificationFactory extends Factory
{
    protected $model = Specification::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $productIds = Product::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();
        $attributeIds = Attribute::pluck('id')->toArray();

        $attributeValuesByAttribute = AttributeValue::select('id', 'attribute_id')
            ->get()
            ->groupBy('attribute_id')
            ->map(function ($group) {
                return $group->pluck('id')->toArray();
            })
            ->toArray();

        $attrId = $this->faker->randomElement($attributeIds);
        $valueIds = $attributeValuesByAttribute[$attrId] ?? [];
        $attributeValueId = ! empty($valueIds) ? $this->faker->randomElement($valueIds) : null;

        return [
            'product_id' => $this->faker->randomElement($productIds),
            'attribute_id' => $attrId,
            'attribute_value_id' => $attributeValueId,
            'desc' => $this->faker->optional()->realText(1000),
            'is_favorite' => $this->faker->boolean(20), // 20% chance of true
            'order' => $this->faker->optional()->numberBetween(1, 100),
            'created_by' => $this->faker->randomElement($userIds),
        ];
    }
}
