<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Filament\Resources\Products\Pages;

use Filament\Resources\Pages\CreateRecord;
use Mortezaa97\Shop\Filament\Resources\Products\ProductResource;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;
}
