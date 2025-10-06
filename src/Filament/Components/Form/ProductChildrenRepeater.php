<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Filament\Components\Form;

use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Mortezaa97\Shop\Models\Product;

class ProductChildrenRepeater extends Section
{
    public static function create(): static
    {
        return parent::make('تنوع‌های محصول')
            ->schema([
                Repeater::make('children')
                    ->relationship()
                    ->schema([
                        \App\Filament\Components\Form\NameTextInput::create()->required(),
                        \App\Filament\Components\Form\CodeTextInput::create()->required(),
                        \App\Filament\Components\Form\PriceTextInput::create()->required(),
                        \App\Filament\Components\Form\QuantityTextInput::create()->required(),
                        \Filament\Forms\Components\TextInput::make('sku')->maxLength(255),
                        \Filament\Forms\Components\TextInput::make('sale_price'),
                        \App\Filament\Components\Form\PartnerPriceTextInput::create(),
                        \App\Filament\Components\Form\DateFromDatePicker::create(),
                        \App\Filament\Components\Form\DateToDatePicker::create(),
                        \App\Filament\Components\Form\StatusSelect::create(Product::class),
                    ])
                    ->columns(3)
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                    ->addActionLabel('افزودن تنوع')
                    ->reorderableWithButtons()
                    ->cloneable()
                    ->deleteAction(
                        fn ($action) => $action->requiresConfirmation()
                    )
                    ->columnSpan(12),
            ])
            ->collapsible()
            ->collapsed()
            ->columns(12)
            ->columnSpan(12);
    }
}
