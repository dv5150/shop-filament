<?php

namespace DV5150\Shop\Filament\Resources\OrderResource\Pages;

use DV5150\Shop\Filament\Resources\OrderResource;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
