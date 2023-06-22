<?php

namespace DV5150\Shop\Filament\Resources\CouponResource\Pages;

use DV5150\Shop\Filament\Resources\CouponResource;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListCoupons extends ListRecords
{
    protected static string $resource = CouponResource::class;

    protected function getTableQuery(): Builder
    {
        return static::getResource()::getEloquentQuery()
            ->with('coupon');
    }

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
