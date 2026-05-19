<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Mortezaa97\Shop\Models\Product;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \App\Filament\Components\Table\ImageImageColumn::create(),
                \App\Filament\Components\Table\HoverImageColumn::create()->toggleable(isToggledHiddenByDefault:true),
                \App\Filament\Components\Table\CodeTextColumn::create(),
                \App\Filament\Components\Table\NameTextColumn::create(),
                \Filament\Tables\Columns\TextColumn::make('english_name')->toggleable(isToggledHiddenByDefault:true)->searchable(),
                \App\Filament\Components\Table\SlugTextColumn::create(),
                \Filament\Tables\Columns\TextColumn::make('sku')->label('SKU')->searchable()->toggleable(isToggledHiddenByDefault:true),
                \Filament\Tables\Columns\TextColumn::make('sale_price')->numeric()->sortable()->toggleable(isToggledHiddenByDefault:true),
                \Filament\Tables\Columns\TextColumn::make('partner_price')->numeric()->sortable()->toggleable(isToggledHiddenByDefault:true),
                \Filament\Tables\Columns\TextColumn::make('date_from')->date()->sortable()->toggleable(isToggledHiddenByDefault:true),
                \Filament\Tables\Columns\TextColumn::make('date_to')->date()->sortable()->toggleable(isToggledHiddenByDefault:true),
                \Filament\Tables\Columns\TextColumn::make('delivery_price')->numeric()->sortable()->toggleable(isToggledHiddenByDefault:true),
                \Filament\Tables\Columns\TextColumn::make('time_to_send')->numeric()->sortable()->toggleable(isToggledHiddenByDefault:true),
                \Filament\Tables\Columns\TextColumn::make('user_price')->numeric()->sortable()->toggleable(isToggledHiddenByDefault:true),
                \App\Filament\Components\Table\MetaTitleTextColumn::create()->toggleable(isToggledHiddenByDefault:true),
                \App\Filament\Components\Table\MetaKeywordsTextColumn::create()->toggleable(isToggledHiddenByDefault:true),
                \App\Filament\Components\Table\StatusTextColumn::create(Product::class)->toggleable(isToggledHiddenByDefault:true),
                \App\Filament\Components\Table\ViewsTextColumn::create()->toggleable(isToggledHiddenByDefault:true),
                \Filament\Tables\Columns\IconColumn::make('is_original')->label('آیا کالا اصل است')->toggleable(isToggledHiddenByDefault:true)->boolean(),
                \Filament\Tables\Columns\TextColumn::make('increase_step')->toggleable(isToggledHiddenByDefault:true)->numeric()->sortable(),
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
