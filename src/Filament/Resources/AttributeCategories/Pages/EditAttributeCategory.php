<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Filament\Resources\AttributeCategories\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Mortezaa97\Shop\Filament\Resources\AttributeCategories\AttributeCategoryResource;

class EditAttributeCategory extends EditRecord
{
    protected static string $resource = AttributeCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
