<?php

namespace Mortezaa97\Shop\Filament\Resources\AttributeValues\Pages;

use Mortezaa97\Shop\Filament\Resources\AttributeValues\AttributeValueResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAttributeValues extends ListRecords
{
    protected static string $resource = AttributeValueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
