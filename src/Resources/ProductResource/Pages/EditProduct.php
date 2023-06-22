<?php

namespace DV5150\Shop\Filament\Resources\ProductResource\Pages;

use DV5150\Shop\Filament\Resources\ProductResource;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
