<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Filament\Resources\AttributeValues\Pages;

use Filament\Resources\Pages\CreateRecord;
use Mortezaa97\Shop\Filament\Resources\AttributeValues\AttributeValueResource;

class CreateAttributeValue extends CreateRecord
{
    protected static string $resource = AttributeValueResource::class;
}
