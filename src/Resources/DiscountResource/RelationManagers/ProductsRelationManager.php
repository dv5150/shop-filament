<?php

namespace DV5150\Shop\Filament\Resources\DiscountResource\RelationManagers;

use DV5150\Shop\Filament\Resources\ProductResource;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\DetachBulkAction;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return ProductResource::form($form);
    }

    public static function table(Table $table): Table
    {
        return ProductResource::table($table)
            ->headerActions([
                AttachAction::make()
                    ->preloadRecordSelect()
            ])
            ->bulkActions([
                DetachBulkAction::make()
            ]);
    }
}
