<?php

namespace Mortezaa97\Shop\Filament\Resources\Specifications;

use Mortezaa97\Shop\Filament\Resources\Specifications\Pages\CreateSpecification;
use Mortezaa97\Shop\Filament\Resources\Specifications\Pages\EditSpecification;
use Mortezaa97\Shop\Filament\Resources\Specifications\Pages\ListSpecifications;
use Mortezaa97\Shop\Filament\Resources\Specifications\Schemas\SpecificationForm;
use Mortezaa97\Shop\Filament\Resources\Specifications\Tables\SpecificationsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mortezaa97\Shop\Models\Specification;

class SpecificationResource extends Resource
{
    protected static ?string $model = Specification::class;

    protected static ?string $navigationLabel = 'مشخصات';

    protected static ?string $modelLabel = 'مشخصات';

    protected static ?string $pluralModelLabel = 'مشخصات';

    protected static string|null|\UnitEnum $navigationGroup = 'فروشگاه';
    protected static ?string $recordTitleAttribute = 'Specification';

    public static function form(Schema $schema): Schema
    {
        return SpecificationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SpecificationsTable::configure($table);
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
            'index' => ListSpecifications::route('/'),
            'create' => CreateSpecification::route('/create'),
            'edit' => EditSpecification::route('/{record}/edit'),
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
