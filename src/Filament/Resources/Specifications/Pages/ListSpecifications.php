<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Filament\Resources\Specifications\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Mortezaa97\Shop\Filament\Resources\Specifications\SpecificationResource;

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
