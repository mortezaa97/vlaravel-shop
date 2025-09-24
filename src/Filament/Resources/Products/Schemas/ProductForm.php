<?php

namespace Mortezaa97\Shop\Filament\Resources\Products\Schemas;

use Mortezaa97\Shop\Models\Product;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Schemas\Components\Group::make()
                ->schema([
                    \Filament\Schemas\Components\Section::make('سئو و بهینه سازی')
                        ->schema([
                            \App\Filament\Components\Form\MetaTitleTextInput::create()->columnSpan(12),
                            \App\Filament\Components\Form\MetaDescTextarea::create()->columnSpan(12),
                            \App\Filament\Components\Form\MetaKeywordsTagsInput::create(),
                        ])
                        ->collapsed()
                        ->collapsible()
                        ->columns(12)
                        ->columnSpan(12),
                    \Filament\Schemas\Components\Section::make()
                        ->schema([
                            \App\Filament\Components\Form\NameTextInput::create()->required(),
                            \App\Filament\Components\Form\EnglishNameTextInput::create(),
                            \App\Filament\Components\Form\CodeTextInput::create()->required(),
                            \App\Filament\Components\Form\SlugTextInput::create()->required(),
                            \App\Filament\Components\Form\ExcerptTextarea::create(),
                            \App\Filament\Components\Form\DescTextarea::create(),
                            \App\Filament\Components\Form\PriceTextInput::create()->required(),
                            \App\Filament\Components\Form\QuantityTextInput::create()->required(),
                            \Filament\Forms\Components\TextInput::make('sku')->maxLength(255),
                            \Filament\Forms\Components\TextInput::make('sale_price'),
                            \App\Filament\Components\Form\PartnerPriceTextInput::create(),
                            \App\Filament\Components\Form\DateFromDatePicker::create(),
                            \App\Filament\Components\Form\DateToDatePicker::create(),
                            \App\Filament\Components\Form\DeliveryPriceTextInput::create(),
                            \Filament\Forms\Components\TextInput::make('time_to_send'),
                            \Filament\Forms\Components\TextInput::make('user_price'),
                            \Filament\Forms\Components\TextInput::make('parent_id'),

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
                            \App\Filament\Components\Form\HoverFileUpload::create()->columnSpan(12),
                            \App\Filament\Components\Form\GalleryFileUpload::create(),
                            \App\Filament\Components\Form\StatusSelect::create(Product::class),
                            \App\Filament\Components\Form\ViewsTextInput::create()->required(),
                            \App\Filament\Components\Form\IsOriginalToggle::create()->required(),
                            \Filament\Forms\Components\TextInput::make('increase_step')->required()->columnSpan(12),
                            \App\Filament\Components\Form\CreatedBySelect::create()->required(),
                            \App\Filament\Components\Form\UpdatedBySelect::create(),
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
