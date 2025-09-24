<?php

namespace Mortezaa97\Shop\Filament\Resources\Products;

use Mortezaa97\Shop\Filament\Resources\Products\Pages\CreateProduct;
use Mortezaa97\Shop\Filament\Resources\Products\Pages\EditProduct;
use Mortezaa97\Shop\Filament\Resources\Products\Pages\ListProducts;
use Mortezaa97\Shop\Filament\Resources\Products\Schemas\ProductForm;
use Mortezaa97\Shop\Filament\Resources\Products\Tables\ProductsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mortezaa97\Shop\Models\Product;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationLabel = 'محصولات';

    protected static ?string $modelLabel = 'محصول';

    protected static ?string $pluralModelLabel = 'محصولات';

    protected static string|null|\UnitEnum $navigationGroup = 'فروشگاه';
    protected static ?string $recordTitleAttribute = 'محصولات';

    public static function form(Schema $schema): Schema
    {
        return ProductForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
