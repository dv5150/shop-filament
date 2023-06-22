<?php

namespace DV5150\Shop\Filament\Resources\OrderResource\Pages;

use DV5150\Shop\Filament\Resources\OrderResource;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getTableQuery(): Builder
    {
        return static::getResource()::getEloquentQuery()
            ->withAggregate(
                'items as price_gross',
                'sum(quantity * price_gross)'
            );
    }

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
