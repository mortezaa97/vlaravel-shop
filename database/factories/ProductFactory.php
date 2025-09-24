<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
        $name = $this->faker->words(3, true); // Generate a 3-word product name

        $date_from = $this->faker->optional(0.5)->dateTimeThisYear();
        $date_to = $this->faker->optional(0.5)->dateTimeThisYear('+6 months');

        if ($date_from !== null && $date_to !== null) {
            $sale_price = $this->faker->numberBetween(1000, 1000000);
        } else {
            $sale_price = $this->faker->optional()->numberBetween(1000, 1000000);
        }

        $existingProductIds = Product::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();

        return [
            'name' => $name,
            'english_name' => $this->faker->optional()->words(3, true), // Nullable
            'code' => $this->faker->unique()->ean13(), // Unique product code (e.g., barcode)
            'slug' => Str::slug($name) . '-' . $this->faker->unique()->numberBetween(1000, 9999), // Unique slug
            'image' => $this->faker->optional()->passthrough('files/image' . $this->faker->numberBetween(1, 100) . '.png'), // Nullable, e.g., files/image42.png
            'hover' => $this->faker->optional()->passthrough('files/hover' . $this->faker->numberBetween(1, 100) . '.png'), // Nullable, e.g., files/hover17.png
            'gallery' => $this->faker->randomElements(
                array_map(fn($i) => 'files/gallery' . $i . '.png', range(1, 3)),
                $this->faker->numberBetween(1, 3)
            ),
            'excerpt' => $this->faker->optional()->sentence(), // Nullable
            'desc' => $this->faker->optional()->paragraph(), // Nullable
            'price' => $this->faker->numberBetween(10, 1000) * 1000, // Round numbers like 10000, 11000, ..., 1000000
            'quantity' => $this->faker->numberBetween(0, 100), // Non-negative quantity
            'sku' => $this->faker->optional()->bothify('SKU-#####'), // Nullable warehouse ID
            'sale_price' => $sale_price,
            'partner_price' => $this->faker->optional()->numberBetween(1000, 1000000), // Nullable
            'date_from' => $date_from, // Nullable
            'date_to' => $date_to, // Nullable
            'delivery_price' => $this->faker->optional()->numberBetween(1000, 50000), // Nullable
            'time_to_send' => $this->faker->optional()->numberBetween(1, 30), // Nullable (days)
            'user_price' => $this->faker->optional()->numberBetween(1000, 1000000), // Nullable
            'meta_title' => $this->faker->optional()->sentence(5), // Nullable
            'meta_desc' => $this->faker->optional()->paragraph(), // Nullable
            'meta_keywords' => $this->faker->optional()->words(5, true), // Nullable
            'status' => $this->faker->optional()->randomElement([
                Status::PUBLISHED,
                Status::DRAFT,
                Status::UNPUBLISHED,
            ]), // Nullable (e.g., 0=inactive, 1=active)
            'views' => $this->faker->numberBetween(0, 10000), // Default 0, but random views for realism
            'is_original' => $this->faker->boolean(), // Boolean
            'increase_step' => $this->faker->numberBetween(1, 10), // Small integer for increment step
            'parent_id' => $this->faker->optional(0.2)->randomElement($existingProductIds ?: [null]), // Nullable, occasionally references an existing product
            'created_by' => $this->faker->randomElement($userIds),
            'updated_by' => $this->faker->optional()->randomElement(User::pluck('id')->toArray() ?: [null]), // Nullable
            'created_at' => $this->faker->dateTimeThisYear(),
            'updated_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}
