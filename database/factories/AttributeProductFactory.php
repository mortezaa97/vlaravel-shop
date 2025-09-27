<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Database\Factories;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Mortezaa97\Shop\Models\Attribute;
use Mortezaa97\Shop\Models\AttributeCategory;
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
        $productIds = Product::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();

        // Ensure unique product_id and attribute_id combination with retry limit
        $maxRetries = 100;
        $attempts = 0;
        $attribute_id = null;
        $product_id = null;

        do {
            if ($attempts++ >= $maxRetries) {
                throw new Exception('No unique product_id and attribute_id combinations available.');
            }

            $product_id = ! empty($productIds) ? $this->faker->randomElement($productIds) : null;

            // Get categories for the selected product
            $categoryIds = DB::table('model_has_categories')
                ->where('model_type', 'App\\Models\\Product')
                ->where('model_id', $product_id)
                ->pluck('category_id')
                ->toArray();

            if (empty($categoryIds)) {
                continue; // Skip if no categories
            }

            // Get eligible attribute IDs for variant from AttributeCategories
            $eligibleAttributeIds = AttributeCategory::whereIn('category_id', $categoryIds)
                ->where('can_variant', true)
                ->pluck('attribute_id')
                ->unique()
                ->toArray();

            if (empty($eligibleAttributeIds)) {
                continue; // Skip if no eligible attributes
            }

            $attribute_id = $this->faker->randomElement($eligibleAttributeIds);

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
