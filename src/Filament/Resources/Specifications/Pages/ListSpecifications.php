<?php

namespace Mortezaa97\Shop\Filament\Resources\Specifications\Pages;

use Mortezaa97\Shop\Filament\Resources\Specifications\SpecificationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSpecifications extends ListRecords
{
    protected static string $resource = SpecificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
