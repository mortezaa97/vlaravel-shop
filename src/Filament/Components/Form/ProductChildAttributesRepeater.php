<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Filament\Components\Form;

use App\Filament\Components\Form\CreatedByHidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Mortezaa97\Shop\Models\Attribute;
use Mortezaa97\Shop\Models\AttributeValue;
use Mortezaa97\Shop\Models\Product;

class ProductChildAttributesRepeater
{
    public static function create(): Repeater
    {
        return Repeater::make('attributeProducts')
            ->hiddenLabel()
            ->relationship()
            ->schema([
                Select::make('attribute_id')
                    ->label('ویژگی')
                    ->options(function (Get $get, $state) {
                        // Get category IDs from the main product form
                        // Path: attributeProducts -> child item -> children repeater -> main form
                        $categoryIds = $get('../../../../categories');

                        if (! $categoryIds || empty($categoryIds)) {
                            return [];
                        }

                        // Get attributes that are associated with these categories and can be used for variants
                        $attributes = Attribute::whereHas('categories', function ($query) use ($categoryIds) {
                            $query->whereIn('category_id', $categoryIds)
                                ->where('can_variant', true);
                        })->get();

                        return $attributes->pluck('name', 'id')->toArray();
                    })
                    ->required()
                    ->live()
                    ->searchable()
                    ->preload()
                    ->afterStateUpdated(function ($state, Set $set) {
                        if (! $state) {
                            $set('attribute_value_id', null);

                            return;
                        }
                    })
                    ->columnSpan(6),

                Select::make('attribute_value_id')
                    ->label('مقدار ویژگی')
                    ->options(function (Get $get) {
                        $attributeId = $get('attribute_id');
                        if (! $attributeId) {
                            return [];
                        }

                        return AttributeValue::where('attribute_id', $attributeId)
                            ->pluck('title', 'id');
                    })
                    ->required()
                    ->searchable()
                    ->preload()
                    ->columnSpan(6),

                CreatedByHidden::create(),
            ])
            ->columns(12)
            ->collapsible()
            ->collapsed()
            ->itemLabel(function (array $state): ?string {
                if (! isset($state['attribute_id']) || ! isset($state['attribute_value_id'])) {
                    return null;
                }

                $attribute = Attribute::find($state['attribute_id']);
                $value = AttributeValue::find($state['attribute_value_id']);

                return ($attribute?->name ?? '') . ': ' . ($value?->title ?? '');
            })
            ->addActionLabel('افزودن ویژگی')
            ->reorderableWithButtons()
            ->deleteAction(
                fn ($action) => $action->requiresConfirmation()
            )
            ->defaultItems(0);
    }
}
