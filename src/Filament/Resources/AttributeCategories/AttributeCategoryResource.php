<?php

namespace Mortezaa97\Shop\Filament\Resources\AttributeCategories;

use Mortezaa97\Shop\Filament\Resources\AttributeCategories\Pages\CreateAttributeCategory;
use Mortezaa97\Shop\Filament\Resources\AttributeCategories\Pages\EditAttributeCategory;
use Mortezaa97\Shop\Filament\Resources\AttributeCategories\Pages\ListAttributeCategories;
use Mortezaa97\Shop\Filament\Resources\AttributeCategories\Schemas\AttributeCategoryForm;
use Mortezaa97\Shop\Filament\Resources\AttributeCategories\Tables\AttributeCategoriesTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mortezaa97\Shop\Models\AttributeCategory;

class AttributeCategoryResource extends Resource
{
    protected static ?string $model = AttributeCategory::class;

    protected static ?string $navigationLabel = 'ویژگی های دسته بندی';

    protected static ?string $modelLabel = 'ویژگی های دسته بندی';

    protected static ?string $pluralModelLabel = 'ویژگی های دسته بندی';

    protected static string|null|\UnitEnum $navigationGroup = 'فروشگاه';

    protected static ?string $recordTitleAttribute = 'ویژگی های دسته بندی';

    public static function form(Schema $schema): Schema
    {
        return AttributeCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AttributeCategoriesTable::configure($table);
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
            'index' => ListAttributeCategories::route('/'),
            'create' => CreateAttributeCategory::route('/create'),
            'edit' => EditAttributeCategory::route('/{record}/edit'),
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
