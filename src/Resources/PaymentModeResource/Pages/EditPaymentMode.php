<?php

namespace DV5150\Shop\Filament\Resources\PaymentModeResource\Pages;

use DV5150\Shop\Filament\Resources\PaymentModeResource;
use Filament\Resources\Pages\EditRecord;

class EditPaymentMode extends EditRecord
{
    protected static string $resource = PaymentModeResource::class;

    protected function getActions(): array
    {
        return [
            //
        ];
    }
}
