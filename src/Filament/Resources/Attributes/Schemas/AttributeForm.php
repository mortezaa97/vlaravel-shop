<?php

namespace Mortezaa97\Shop\Filament\Resources\Attributes\Schemas;

use Filament\Schemas\Schema;

class AttributeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Schemas\Components\Group::make()
                ->schema([
                    \Filament\Schemas\Components\Section::make()
                        ->schema([
                            \App\Filament\Components\Form\NameTextInput::create()->required(),
                            \App\Filament\Components\Form\SlugTextInput::create()->required(),
                            \Filament\Forms\Components\TextInput::make('parent_id')->columnSpan(12),

                        ])
                        ->columns(12)
                        ->columnSpan(12),
                ])
                ->columns(12)
                ->columnSpan(8),
            \Filament\Schemas\Components\Group::make()
                ->schema([
                    \Filament\Schemas\Components\Section::make()
                        ->schema([
                            \App\Filament\Components\Form\ImageFileUpload::create(),
                            \App\Filament\Components\Form\OrderTextInput::create()->columnSpan(12),
                        ])
                        ->columns(12)
                        ->columnSpan(12),
                ])
                ->columns(12)
                ->columnSpan(4),
        ])
            ->columns(12);
    }
}
