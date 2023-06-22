<?php

namespace DV5150\Shop\Filament\Resources;

use DV5150\Shop\Filament\Resources\PaymentModeResource\Pages\CreatePaymentMode;
use DV5150\Shop\Filament\Resources\PaymentModeResource\Pages\EditPaymentMode;
use DV5150\Shop\Filament\Resources\PaymentModeResource\Pages\ListPaymentModes;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;

class PaymentModeResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $slug = 'shop/payment-modes';

    protected static ?string $navigationGroup = 'Shop';

    protected static ?string $navigationLabel = 'Payment Modes';

    public static function getModel(): string
    {
        return config('shop.models.paymentMode');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                TextInput::make('price_gross')
                    ->nullable()
                    ->numeric()
                    ->label('Gross Price (' . config('shop.currency.code') . ')'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('price_gross')
                    ->label('Gross Price (' . config('shop.currency.code') . ')'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPaymentModes::route('/'),
            'create' => CreatePaymentMode::route('/create'),
            'edit' => EditPaymentMode::route('/{record}/edit'),
        ];
    }
}
