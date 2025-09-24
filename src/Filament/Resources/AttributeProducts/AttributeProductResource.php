<?php

namespace Mortezaa97\Shop\Filament\Resources\AttributeProducts;

use Mortezaa97\Shop\Filament\Resources\AttributeProducts\Pages\CreateAttributeProduct;
use Mortezaa97\Shop\Filament\Resources\AttributeProducts\Pages\EditAttributeProduct;
use Mortezaa97\Shop\Filament\Resources\AttributeProducts\Pages\ListAttributeProducts;
use Mortezaa97\Shop\Filament\Resources\AttributeProducts\Schemas\AttributeProductForm;
use Mortezaa97\Shop\Filament\Resources\AttributeProducts\Tables\AttributeProductsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mortezaa97\Shop\Models\AttributeProduct;

class AttributeProductResource extends Resource
{
    protected static ?string $model = AttributeProduct::class;

    protected static ?string $navigationLabel = 'ویژگی های محصول';

    protected static ?string $modelLabel = 'ویژگی های محصول';

    protected static ?string $pluralModelLabel = 'ویژگی های محصول';

    protected static string|null|\UnitEnum $navigationGroup = 'فروشگاه';
    protected static ?string $recordTitleAttribute = 'ویژگی های محصول';

    public static function form(Schema $schema): Schema
    {
        return AttributeProductForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AttributeProductsTable::configure($table);
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
            'index' => ListAttributeProducts::route('/'),
            'create' => CreateAttributeProduct::route('/create'),
            'edit' => EditAttributeProduct::route('/{record}/edit'),
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
