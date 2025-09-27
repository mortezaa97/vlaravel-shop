<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Mortezaa97\Shop\Models\Attribute;
use Mortezaa97\Shop\Models\AttributeProduct;
use Mortezaa97\Shop\Models\AttributeValue;
use Mortezaa97\Shop\Models\Product;

/**
 * @extends Factory<AttributeProduct>
 */
class AttributeProductFactory extends Factory
{
    protected $model = AttributeProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $attributeIds = Attribute::pluck('id')->toArray();
        $productIds = Product::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();

        // Ensure unique product_id and attribute_id combination with retry limit
        $maxRetries = 100;
        $attempts = 0;
        do {
            if ($attempts++ >= $maxRetries) {
                throw new \Exception('No unique product_id and attribute_id combinations available.');
            }
            $attribute_id = $this->faker->randomElement($attributeIds);
            $product_id = ! empty($productIds) ? $this->faker->randomElement($productIds) : null;
            $exists = AttributeProduct::where('product_id', $product_id)
                ->where('attribute_id', $attribute_id)
                ->exists();
        } while ($exists);

        $attributeValueIds = AttributeValue::where('attribute_id', $attribute_id)->pluck('id')->toArray();

        return [
            'attribute_id' => $attribute_id,
            'product_id' => $product_id,
            'attribute_value_id' => ! empty($attributeValueIds) ? $this->faker->randomElement($attributeValueIds) : null,
            'created_by' => ! empty($userIds) ? $this->faker->randomElement($userIds) : null,
            'updated_by' => $this->faker->optional()->randomElement($userIds ?: [null]),
        ];
    }
}
