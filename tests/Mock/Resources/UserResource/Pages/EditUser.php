<?php

namespace DV5150\Shop\Filament\Tests\Mock\Resources\UserResource\Pages;

use DV5150\Shop\Filament\Resources\OrderResource;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
