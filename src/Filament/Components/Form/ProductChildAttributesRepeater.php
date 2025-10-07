<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Filament\Components\Form;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Support\Facades\Auth;
use Mortezaa97\Shop\Models\Attribute;
use Mortezaa97\Shop\Models\AttributeValue;

class ProductChildAttributesRepeater
{
    public static function create(): Fieldset
    {
        return Fieldset::make('ویژگی‌ها')
            ->columns(1)
            ->schema(function (Get $get, $record) {
                // Get category IDs from the parent product record
                $categoryIds = null;

                // If we have a record (child product), try to get categories from its parent
                if ($record && $record->exists && $record->parent_id) {
                    $parent = $record->parent()->first();
                    if ($parent) {
                        $categoryIds = $parent->categories()->pluck('categories.id')->toArray();
                    }
                }

                // Fall back to form state if we don't have a parent record yet (creating new child)
                if (! $categoryIds || empty($categoryIds)) {
                    $categoryIds = $get('../../categories');
                }

                if (! $categoryIds || empty($categoryIds)) {
                    return [
                        Placeholder::make('no_categories')
                            ->label('')
                            ->content('لطفاً ابتدا دسته‌بندی‌های محصول را در مرحله "دسته‌بندی و وضعیت" انتخاب کنید.')
                            ->columnSpanFull(),
                    ];
                }

                // Get attributes that are associated with these categories and can be used for variants
                $attributes = Attribute::whereHas('categories', function ($query) use ($categoryIds) {
                    $query->whereIn('category_id', $categoryIds)
                        ->where('can_variant', true);
                })
                    ->orderBy('name')
                    ->get();

                if ($attributes->isEmpty()) {
                    return [
                        Placeholder::make('no_attributes')
                            ->label('')
                            ->content('هیچ ویژگی قابل استفاده برای تنوع در دسته‌بندی‌های انتخاب شده تعریف نشده است.')
                            ->columnSpanFull(),
                    ];
                }

                // Get existing attribute products for this child variant
                $existingAttributeProducts = [];
                if ($record && $record->exists) {
                    $existingAttributeProducts = $record->attributeProducts()
                        ->pluck('attribute_value_id', 'attribute_id')
                        ->toArray();
                }

                $components = [];
                foreach ($attributes as $attribute) {
                    $components[] = Select::make("attribute_{$attribute->id}")
                        ->label($attribute->name)
                        ->options(function () use ($attribute) {
                            return AttributeValue::where('attribute_id', $attribute->id)
                                ->orderBy('title')
                                ->pluck('title', 'id');
                        })
                        ->searchable()
                        ->preload()
                        ->placeholder('انتخاب کنید...')
                        ->afterStateHydrated(function (Select $component, $state, $record) use ($attribute, $existingAttributeProducts) {
                            // Hydrate from existing relationship data
                            if (isset($existingAttributeProducts[$attribute->id])) {
                                $component->state($existingAttributeProducts[$attribute->id]);
                            }
                        })
                        ->afterStateUpdated(function ($state, Get $get, $record) use ($attribute) {
                            // Handle saving the relationship
                            if ($record && $record->exists) {
                                if ($state) {
                                    // Update or create the attribute product
                                    $record->attributeProducts()->updateOrCreate(
                                        ['attribute_id' => $attribute->id],
                                        [
                                            'attribute_value_id' => $state,
                                            'created_by' => Auth::id(),
                                            'updated_by' => Auth::id(),
                                        ]
                                    );
                                } else {
                                    // Remove the attribute product if deselected
                                    $record->attributeProducts()
                                        ->where('attribute_id', $attribute->id)
                                        ->delete();
                                }
                            }
                        })
                        ->live(onBlur: true)
                        ->dehydrated(false) // Don't save to main form data
                        ->columnSpanFull();
                }

                return $components;
            });
    }
}
