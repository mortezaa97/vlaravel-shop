<?php

namespace Mortezaa97\Shop\Filament\Resources\AttributeValues;

use Mortezaa97\Shop\Filament\Resources\AttributeValues\Pages\CreateAttributeValue;
use Mortezaa97\Shop\Filament\Resources\AttributeValues\Pages\EditAttributeValue;
use Mortezaa97\Shop\Filament\Resources\AttributeValues\Pages\ListAttributeValues;
use Mortezaa97\Shop\Filament\Resources\AttributeValues\Schemas\AttributeValueForm;
use Mortezaa97\Shop\Filament\Resources\AttributeValues\Tables\AttributeValuesTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mortezaa97\Shop\Models\AttributeValue;

class AttributeValueResource extends Resource
{
    protected static ?string $model = AttributeValue::class;

    protected static ?string $navigationLabel = 'مقادیرویژگی ها';

    protected static ?string $modelLabel = 'مقادیرویژگی ها';

    protected static ?string $pluralModelLabel = 'مقادیرویژگی ها';

    protected static string|null|\UnitEnum $navigationGroup = 'فروشگاه';
    protected static ?string $recordTitleAttribute = 'مقادیر مجاز ویژگی ها';

    public static function form(Schema $schema): Schema
    {
        return AttributeValueForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AttributeValuesTable::configure($table);
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
            'index' => ListAttributeValues::route('/'),
            'create' => CreateAttributeValue::route('/create'),
            'edit' => EditAttributeValue::route('/{record}/edit'),
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
