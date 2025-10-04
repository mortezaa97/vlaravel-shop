<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Filament\Resources\Attributes\Pages;

use Filament\Resources\Pages\CreateRecord;
use Mortezaa97\Shop\Filament\Resources\Attributes\AttributeResource;

class CreateAttribute extends CreateRecord
{
    protected static string $resource = AttributeResource::class;
}
