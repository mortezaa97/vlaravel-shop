<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Filament\Components\Form;

use App\Filament\Components\Form\CreatedByHidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Utilities\Get;
use Mortezaa97\Shop\Models\Attribute;
use Mortezaa97\Shop\Models\AttributeValue;

class ProductChildAttributesFieldset
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

                return [
                    Repeater::make('attributeProducts')
                        ->label('ویژگی‌های محصول')
                        ->relationship()
                        ->schema([
                            Select::make('attribute_id')
                                ->label('ویژگی')
                                ->options($attributes->pluck('name', 'id'))
                                ->required()
                                ->searchable()
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set) {
                                    // Clear attribute value when attribute changes
                                    $set('attribute_value_id', null);
                                }),

                            Select::make('attribute_value_id')
                                ->label('مقدار ویژگی')
                                ->options(function (callable $get) {
                                    $attributeId = $get('attribute_id');
                                    if (! $attributeId) {
                                        return [];
                                    }

                                    return AttributeValue::where('attribute_id', $attributeId)
                                        ->orderBy('title')
                                        ->pluck('title', 'id');
                                })
                                ->required()
                                ->searchable()
                                ->preload()
                                ->placeholder('انتخاب کنید...'),

                            CreatedByHidden::create(),
                        ])
                        ->columns(2)
                        ->defaultItems(0)
                        ->addActionLabel('افزودن ویژگی')
                        ->deleteAction(
                            fn ($action) => $action->requiresConfirmation()
                        )
                        ->reorderableWithButtons()
                        ->collapsible()
                        ->collapsed()
                        ->columnSpanFull(),
                ];
            });
    }
}
