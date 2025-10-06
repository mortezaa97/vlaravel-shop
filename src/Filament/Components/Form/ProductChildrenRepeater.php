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
                \App\Filament\Components\Form\NameTextInput::create()->required(),
                \App\Filament\Components\Form\PriceTextInput::create()->required(),
                \App\Filament\Components\Form\QuantityTextInput::create()->required(),
                \App\Filament\Components\Form\CreatedBySelect::create(),
            ])
            ->columns(4)
            ->collapsible()
            ->collapsed()
            ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
            ->addActionLabel('افزودن تنوع')
            ->reorderableWithButtons()
            ->cloneable()
            ->deleteAction(
                fn ($action) => $action->requiresConfirmation()
            );
    }
}
