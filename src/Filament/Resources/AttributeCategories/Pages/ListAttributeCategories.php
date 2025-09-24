<?php

namespace Mortezaa97\Shop\Filament\Resources\AttributeCategories\Pages;

use Mortezaa97\Shop\Filament\Resources\AttributeCategories\AttributeCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAttributeCategories extends ListRecords
{
    protected static string $resource = AttributeCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
