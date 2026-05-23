<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Filament\Resources\AttributeCategories\Pages;

use Filament\Resources\Pages\CreateRecord;
use Mortezaa97\Shop\Filament\Resources\AttributeCategories\AttributeCategoryResource;

class CreateAttributeCategory extends CreateRecord
{
    protected static string $resource = AttributeCategoryResource::class;
}
