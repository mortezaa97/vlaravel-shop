<?php

namespace Mortezaa97\Shop\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \App\Filament\Components\Table\NameTextColumn::create(),
                \Filament\Tables\Columns\TextColumn::make('english_name')->searchable(),
                \App\Filament\Components\Table\CodeTextColumn::create(),
                \App\Filament\Components\Table\SlugTextColumn::create(),
                \App\Filament\Components\Table\ImageImageColumn::create(),
                \Filament\Tables\Columns\TextColumn::make('hover')->searchable(),
                \App\Filament\Components\Table\PriceTextColumn::create(),
                \App\Filament\Components\Table\QuantityTextColumn::create(),
                \Filament\Tables\Columns\TextColumn::make('sku')->label('SKU')->searchable(),
                \Filament\Tables\Columns\TextColumn::make('sale_price')->numeric()->sortable(),
                \Filament\Tables\Columns\TextColumn::make('partner_price')->numeric()->sortable(),
                \Filament\Tables\Columns\TextColumn::make('date_from')->date()->sortable(),
                \Filament\Tables\Columns\TextColumn::make('date_to')->date()->sortable(),
                \Filament\Tables\Columns\TextColumn::make('delivery_price')->numeric()->sortable(),
                \Filament\Tables\Columns\TextColumn::make('time_to_send')->numeric()->sortable(),
                \Filament\Tables\Columns\TextColumn::make('user_price')->numeric()->sortable(),
                \App\Filament\Components\Table\MetaTitleTextColumn::create(),
                \App\Filament\Components\Table\MetaKeywordsTextColumn::create(),
                \App\Filament\Components\Table\StatusTextColumn::create(Product::class),
                \App\Filament\Components\Table\ViewsTextColumn::create(),
                \Filament\Tables\Columns\IconColumn::make('is_original')->boolean(),
                \Filament\Tables\Columns\TextColumn::make('increase_step')->numeric()->sortable(),
                \App\Filament\Components\Table\CreatedByTextColumn::create(),
                \App\Filament\Components\Table\UpdatedByTextColumn::create(),
                \App\Filament\Components\Table\DeletedAtTextColumn::create(),
                \App\Filament\Components\Table\CreatedAtTextColumn::create(),
                \App\Filament\Components\Table\UpdatedAtTextColumn::create(),
                \App\Filament\Components\Table\ParentTextColumn::create(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
