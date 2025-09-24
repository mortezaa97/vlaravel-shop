<?php

declare(strict_types=1);

namespace Mortezaa97\Shop;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Mortezaa97\Shop\Filament\Resources\AttributeCategories\AttributeCategoryResource;
use Mortezaa97\Shop\Filament\Resources\AttributeProducts\AttributeProductResource;
use Mortezaa97\Shop\Filament\Resources\Attributes\AttributeResource;
use Mortezaa97\Shop\Filament\Resources\AttributeValues\AttributeValueResource;
use Mortezaa97\Shop\Filament\Resources\Products\ProductResource;
use Mortezaa97\Shop\Filament\Resources\Specifications\SpecificationResource;

class ShopPlugin implements Plugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'shop';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                'AttributeResource' => AttributeResource::class,
                'AttributeCategoryResource' =>AttributeCategoryResource::class,
                'AttributeProductResource' =>AttributeProductResource::class,
                'AttributeValueResource' =>AttributeValueResource::class,
                'ProductResource' =>ProductResource::class,
                'SpecificationResource' =>SpecificationResource::class,

            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
