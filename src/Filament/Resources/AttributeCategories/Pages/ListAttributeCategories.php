<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Filament\Resources\AttributeCategories\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Mortezaa97\Shop\Filament\Resources\AttributeCategories\AttributeCategoryResource;

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
