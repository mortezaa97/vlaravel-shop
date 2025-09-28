<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Database\Factories;

use App\Enums\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Mortezaa97\Shop\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Mortezaa97\Shop\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->words(3, true); // Generate a 3-word product name

        $date_from = fake()->optional(0.8)->dateTimeThisYear();
        $date_to = fake()->optional(0.8)->dateTimeThisYear('+6 months');

        if ($date_from !== null && $date_to !== null) {
            $sale_price = fake()->numberBetween(1000, 1000000);
        } else {
            $sale_price = fake()->optional()->numberBetween(1000, 1000000);
        }

        $existingProductIds = Product::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();

        return [
            'name' => $name,
            'english_name' => fake()->optional()->words(3, true), // Nullable
            'code' => fake()->unique()->ean13(), // Unique product code (e.g., barcode)
            'slug' => Str::slug($name) . '-' . fake()->unique()->numberBetween(1000, 9999), // Unique slug
            'image' => fake()->optional()->passthrough('files/image' . fake()->numberBetween(1, 100) . '.png'), // Nullable, e.g., files/image42.png
            'hover' => fake()->optional()->passthrough('files/hover' . fake()->numberBetween(1, 100) . '.png'), // Nullable, e.g., files/hover17.png
            'gallery' => fake()->randomElements(
                array_map(fn ($i) => 'files/gallery' . $i . '.png', range(1, 3)),
                fake()->numberBetween(1, 3)
            ),
            'excerpt' => fake()->optional()->sentence(), // Nullable
            'desc' => fake()->optional()->paragraph(), // Nullable
            'price' => fake()->numberBetween(10, 1000) * 1000, // Round numbers like 10000, 11000, ..., 1000000
            'quantity' => fake()->numberBetween(0, 100), // Non-negative quantity
            'sku' => fake()->optional()->bothify('SKU-#####'), // Nullable warehouse ID
            'sale_price' => $sale_price,
            'partner_price' => fake()->optional()->numberBetween(1000, 1000000), // Nullable
            'date_from' => $date_from, // Nullable
            'date_to' => $date_to, // Nullable
            'delivery_price' => fake()->optional()->numberBetween(1000, 50000), // Nullable
            'time_to_send' => fake()->optional()->numberBetween(1, 30), // Nullable (days)
            'user_price' => fake()->optional()->numberBetween(1000, 1000000), // Nullable
            'meta_title' => fake()->optional()->sentence(5), // Nullable
            'meta_desc' => fake()->optional()->paragraph(), // Nullable
            'meta_keywords' => fake()->optional()->words(5, true), // Nullable
            'status' => fake()->optional()->randomElement([
                Status::PUBLISHED,
                Status::DRAFT,
                Status::UNPUBLISHED,
            ]), // Nullable (e.g., 0=inactive, 1=active)
            'views' => fake()->numberBetween(0, 10000), // Default 0, but random views for realism
            'is_original' => fake()->boolean(), // Boolean
            'increase_step' => fake()->numberBetween(1, 10), // Small integer for increment step
            'parent_id' => fake()->randomElement($existingProductIds ?: [null]), // Nullable, occasionally references an existing product
            'created_by' => fake()->randomElement($userIds),
            'updated_by' => fake()->optional()->randomElement(User::pluck('id')->toArray() ?: [null]), // Nullable
            'created_at' => fake()->dateTimeThisYear(),
            'updated_at' => fake()->dateTimeThisYear(),
        ];
    }
}
