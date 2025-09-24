<?php

namespace Mortezaa97\Shop\Filament\Resources\AttributeProducts\Pages;

use Mortezaa97\Shop\Filament\Resources\AttributeProducts\AttributeProductResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAttributeProducts extends ListRecords
{
    protected static string $resource = AttributeProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
