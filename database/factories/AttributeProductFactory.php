<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
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

    protected static array $availablePairs = [];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userIds = User::pluck('id')->toArray();

        if (empty(static::$availablePairs)) {
            // Collect all eligible non-existing pairs
            $eligiblePairs = [];

            // Get all product-category mappings
            $productCategories = DB::table('model_has_categories')
                ->where('model_type', 'App\\Models\\Product')
                ->select('model_id as product_id', 'category_id')
                ->get()
                ->groupBy('product_id');

            if ($productCategories->isEmpty()) {
                throw new \Exception('No products with categories available.');
            }

            // Get existing pairs to exclude, grouped by product_id
            $existingPairs = AttributeProduct::select('product_id', 'attribute_id')
                ->get()
                ->groupBy('product_id')
                ->map(function ($group) {
                    return $group->pluck('attribute_id')->toArray();
                })
                ->toArray();

            foreach ($productCategories as $productId => $categories) {
                $categoryIds = $categories->pluck('category_id')->toArray();

                // Get eligible attributes for these categories
                $eligibleAttributeIds = AttributeCategory::whereIn('category_id', $categoryIds)
                    ->where('can_variant', true)
                    ->distinct()
                    ->reorder()
                    ->pluck('attribute_id')
                    ->toArray();

                $existingAttributesForProduct = $existingPairs[$productId] ?? [];

                foreach ($eligibleAttributeIds as $attributeId) {
                    if (!in_array($attributeId, $existingAttributesForProduct)) {
                        $eligiblePairs[] = [
                            'product_id' => $productId,
                            'attribute_id' => $attributeId,
                        ];
                    }
                }
            }

            if (empty($eligiblePairs)) {
                throw new \Exception('No unique product_id and attribute_id combinations available.');
            }

            static::$availablePairs = $eligiblePairs;
            shuffle(static::$availablePairs);
        }

        if (empty(static::$availablePairs)) {
            throw new \Exception('No unique product_id and attribute_id combinations available.');
        }

        // Pick and remove a random eligible pair
        $index = array_rand(static::$availablePairs);
        $randomPair = static::$availablePairs[$index];
        unset(static::$availablePairs[$index]);

        $product_id = $randomPair['product_id'];
        $attribute_id = $randomPair['attribute_id'];

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
