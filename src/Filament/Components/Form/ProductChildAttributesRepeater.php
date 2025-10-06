<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Filament\Components\Form;

use App\Filament\Components\Form\CreatedByHidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Get;
use Mortezaa97\Shop\Models\Attribute;
use Mortezaa97\Shop\Models\AttributeValue;
use Mortezaa97\Shop\Models\Product;

class ProductChildAttributesRepeater
{
    public static function create(): Repeater
    {
        return Repeater::make('attributeProducts')
            ->label('ویژگی‌های محصول')
            ->relationship()
            ->schema([
                Select::make('attribute_id')
                    ->label('ویژگی')
                    ->options(function (Get $get, $state) {
                        // Get the parent product to access its categories
                        $parentProduct = $get('../../..');
                        if (! $parentProduct || ! isset($parentProduct['id'])) {
                            return [];
                        }

                        $product = Product::with('categories')->find($parentProduct['id']);
                        if (! $product) {
                            return [];
                        }

                        // Get category IDs from the parent product
                        $categoryIds = $product->categories->pluck('id')->toArray();

                        // Get attributes that are associated with these categories and can be used for variants
                        $attributes = Attribute::whereHas('categories', function ($query) use ($categoryIds) {
                            $query->whereIn('category_id', $categoryIds)
                                ->where('can_variant', true);
                        })->get();

                        return $attributes->pluck('name', 'id')->toArray();
                    })
                    ->required()
                    ->reactive()
                    ->searchable()
                    ->columnSpan(6),

                Select::make('attribute_value_id')
                    ->label('مقدار ویژگی')
                    ->options(function (Get $get) {
                        $attributeId = $get('attribute_id');
                        if (! $attributeId) {
                            return [];
                        }

                        $values = AttributeValue::where('attribute_id', $attributeId)->get();

                        return $values->pluck('title', 'id')->toArray();
                    })
                    ->required()
                    ->searchable()
                    ->columnSpan(6),

                CreatedByHidden::create(),
            ])
            ->columns(12)
            ->collapsible()
            ->collapsed()
            ->itemLabel(
                fn (array $state): ?string => $state['attribute_id'] ?
                Attribute::find($state['attribute_id'])?->name . ': ' .
                ($state['attribute_value_id'] ? AttributeValue::find($state['attribute_value_id'])?->title : '')
                : null
            )
            ->addActionLabel('افزودن ویژگی')
            ->reorderableWithButtons()
            ->deleteAction(
                fn ($action) => $action->requiresConfirmation()
            );
    }
}
