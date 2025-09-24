<?php

namespace Mortezaa97\Shop\Filament\Resources\Attributes;

use Mortezaa97\Shop\Filament\Resources\Attributes\Pages\CreateAttribute;
use Mortezaa97\Shop\Filament\Resources\Attributes\Pages\EditAttribute;
use Mortezaa97\Shop\Filament\Resources\Attributes\Pages\ListAttributes;
use Mortezaa97\Shop\Filament\Resources\Attributes\Schemas\AttributeForm;
use Mortezaa97\Shop\Filament\Resources\Attributes\Tables\AttributesTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mortezaa97\Shop\Models\Attribute;

class AttributeResource extends Resource
{
    protected static ?string $model = Attribute::class;

    protected static ?string $navigationLabel = 'ویژگی ها';

    protected static ?string $modelLabel = 'ویژگی ها';

    protected static ?string $pluralModelLabel = 'ویژگی ها';

    protected static string|null|\UnitEnum $navigationGroup = 'فروشگاه';
    protected static ?string $recordTitleAttribute = 'ویژگی ها';

    public static function form(Schema $schema): Schema
    {
        return AttributeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AttributesTable::configure($table);
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
            'index' => ListAttributes::route('/'),
            'create' => CreateAttribute::route('/create'),
            'edit' => EditAttribute::route('/{record}/edit'),
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
