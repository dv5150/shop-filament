<?php

namespace DV5150\Shop\Filament\Resources\ShippingModeResource\Pages;

use DV5150\Shop\Filament\Resources\ShippingModeResource;
use Filament\Resources\Pages\ListRecords;

class ListShippingModes extends ListRecords
{
    protected static string $resource = ShippingModeResource::class;

    protected function getActions(): array
    {
        return [
            //
        ];
    }
}
