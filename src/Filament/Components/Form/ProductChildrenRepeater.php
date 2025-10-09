<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Filament\Components\Form;

use Filament\Forms\Components\Repeater;

class ProductChildrenRepeater
{
    public static function create(): Repeater
    {
        return Repeater::make('children')
            ->hiddenLabel()
            ->relationship()
            ->schema([
                \App\Filament\Components\Form\NameTextInput::create()
                    ->required()
                    ->columnSpan(12),
                \App\Filament\Components\Form\PriceTextInput::create()->required()
                    ->columnSpan(6),
                \App\Filament\Components\Form\QuantityTextInput::create()->required()
                    ->columnSpan(6),
                \App\Filament\Components\Form\CreatedByHidden::create(),

                ProductChildAttributesFieldset::create()
                    ->columnSpan(12),
            ])
            ->columns(12)
            ->collapsible()
            ->collapsed()
            ->defaultItems(0)
            ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
            ->addActionLabel('افزودن تنوع')
            ->reorderableWithButtons()
            ->deleteAction(
                fn ($action) => $action->requiresConfirmation()
            );
    }
}
