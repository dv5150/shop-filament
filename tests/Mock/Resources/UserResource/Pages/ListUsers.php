<?php

namespace DV5150\Shop\Filament\Tests\Mock\Resources\UserResource\Pages;

use DV5150\Shop\Filament\Tests\Mock\Resources\UserResource;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getTableQuery(): Builder
    {
        return static::getResource()::getEloquentQuery()
            ->with(['orders', 'shippingAddresses']);
    }

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
