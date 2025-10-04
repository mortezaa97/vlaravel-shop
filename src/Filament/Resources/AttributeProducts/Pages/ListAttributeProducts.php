<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Filament\Resources\AttributeProducts\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Mortezaa97\Shop\Filament\Resources\AttributeProducts\AttributeProductResource;

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
