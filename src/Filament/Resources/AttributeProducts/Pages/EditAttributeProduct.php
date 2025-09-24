<?php

namespace Mortezaa97\Shop\Filament\Resources\AttributeProducts\Pages;

use Mortezaa97\Shop\Filament\Resources\AttributeProducts\AttributeProductResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditAttributeProduct extends EditRecord
{
    protected static string $resource = AttributeProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
