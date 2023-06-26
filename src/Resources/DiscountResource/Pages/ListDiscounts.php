<?php

namespace DV5150\Shop\Filament\Resources\DiscountResource\Pages;

use DV5150\Shop\Filament\Resources\DiscountResource;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListDiscounts extends ListRecords
{
    protected static string $resource = DiscountResource::class;

    protected function getTableQuery(): Builder
    {
        return static::getResource()::getEloquentQuery()
            ->with(['discount']);
    }

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
