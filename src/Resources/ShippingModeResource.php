<?php

namespace DV5150\Shop\Filament\Resources;

use DV5150\Shop\Filament\Resources\ShippingModeResource\Pages\CreateShippingMode;
use DV5150\Shop\Filament\Resources\ShippingModeResource\Pages\EditShippingMode;
use DV5150\Shop\Filament\Resources\ShippingModeResource\Pages\ListShippingModes;
use DV5150\Shop\Filament\Resources\ShippingModeResource\RelationManagers\PaymentModesRelationManager;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;

class ShippingModeResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $slug = 'shop/shipping-modes';

    protected static ?string $navigationGroup = 'Shop';

    protected static ?string $navigationLabel = 'Shipping Modes';

    public static function getModel(): string
    {
        return config('shop.models.shippingMode');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                TextInput::make('price_gross')
                    ->label('Gross Price (' . config('shop.currency.code') . ')')
                    ->numeric()
                    ->required()
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
            PaymentModesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListShippingModes::route('/'),
            'create' => CreateShippingMode::route('/create'),
            'edit' => EditShippingMode::route('/{record}/edit'),
        ];
    }
}
