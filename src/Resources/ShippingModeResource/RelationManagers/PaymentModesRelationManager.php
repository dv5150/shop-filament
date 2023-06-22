<?php

namespace DV5150\Shop\Filament\Resources\ShippingModeResource\RelationManagers;

use DV5150\Shop\Filament\Resources\PaymentModeResource;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Actions\DetachBulkAction;
use Filament\Tables\Actions\EditAction;

class PaymentModesRelationManager extends RelationManager
{
    protected static string $relationship = 'paymentModes';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return PaymentModeResource::form($form);
    }

    public static function table(Table $table): Table
    {
        return PaymentModeResource::table($table)
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make()
                    ->preloadRecordSelect(),
            ])
            ->actions([
                EditAction::make(),
                DetachAction::make(),
            ])
            ->bulkActions([
                DetachBulkAction::make(),
            ]);
    }
}
