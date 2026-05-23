<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Filament\Resources\AttributeValues\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Mortezaa97\Shop\Filament\Resources\AttributeValues\AttributeValueResource;

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
