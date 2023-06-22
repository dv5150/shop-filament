<?php

namespace DV5150\Shop\Filament\Resources\ProductResource\Pages;

use DV5150\Shop\Filament\Resources\ProductResource;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->with('categories');
    }

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
