<?php

namespace Mortezaa97\Shop\Filament\Resources\Specifications\Schemas;

use Filament\Schemas\Schema;

class SpecificationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Schemas\Components\Group::make()
                ->schema([
                    \Filament\Schemas\Components\Section::make()
                        ->schema([
                            \Filament\Forms\Components\TextInput::make('attribute_id')->required(),
                            \Filament\Forms\Components\TextInput::make('product_id')->required(),
                            \Filament\Forms\Components\TextInput::make('attribute_value_id'),
                            \App\Filament\Components\Form\DescTextarea::create(),
                            \Filament\Forms\Components\Toggle::make('is_favorite')->required(),
                            \App\Filament\Components\Form\OrderTextInput::create(),
                            \App\Filament\Components\Form\CreatedBySelect::create()->required(),
                            \App\Filament\Components\Form\UpdatedBySelect::create(),

                        ])
                        ->columns(12)
                        ->columnSpan(12),
                ])
                ->columns(12)
                ->columnSpan(8),
            \Filament\Schemas\Components\Group::make()
                ->schema([
                    \Filament\Schemas\Components\Section::make()
                        ->schema([])
                        ->columns(12)
                        ->columnSpan(12),
                ])
                ->columns(12)
                ->columnSpan(4),
        ])
            ->columns(12);
    }
}
