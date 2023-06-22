<?php

namespace DV5150\Shop\Filament\Resources;

use DV5150\Shop\Filament\Resources\OrderResource\Pages\CreateOrder;
use DV5150\Shop\Filament\Resources\OrderResource\Pages\EditOrder;
use DV5150\Shop\Filament\Resources\OrderResource\Pages\ListOrders;
use DV5150\Shop\Filament\Resources\OrderResource\RelationManagers\ItemsRelationManager;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;

class OrderResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-view-list';

    protected static ?string $slug = 'shop/orders';

    protected static ?string $navigationGroup = 'Shop';

    public static function getModel(): string
    {
        return config('shop.models.order');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Basic information')
                    ->schema([
                        TextInput::make('email')
                            ->email()
                            ->required(),
                        TextInput::make('phone')
                            ->telRegex('/^\\+?[1-9][0-9]{7,14}$/')
                            ->required(),
                        Select::make('user_id')
                            ->relationship('user', 'name'),
                        Textarea::make('comment')
                            ->columnSpan(3),
                    ])->columns(3),
                Section::make('Billing information')
                    ->schema([
                        TextInput::make('billing_name')
                            ->required(),
                        TextInput::make('billing_zip_code')
                            ->required(),
                        TextInput::make('billing_city')
                            ->required(),
                        TextInput::make('billing_address')
                            ->required(),
                        TextInput::make('billing_tax_number')
                            ->required()
                            ->columnSpan(2),
                    ])->columns(2),
                Section::make('Shipping information')
                    ->schema([
                        TextInput::make('shipping_name')
                            ->required(),
                        TextInput::make('shipping_zip_code')
                            ->required(),
                        TextInput::make('shipping_city')
                            ->required(),
                        TextInput::make('shipping_address')
                            ->required(),
                        Textarea::make('shipping_comment')
                            ->columnSpan(2),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('billing_name')
                    ->label('Billing Name'),
                TextColumn::make('email')
                    ->label('E-Mail'),
                TextColumn::make('price_gross')
                    ->label('Total (' . config('shop.currency.code') . ')'),
                TextColumn::make('created_at')
                    ->label('Date'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrders::route('/'),
            'create' => CreateOrder::route('/create'),
            'edit' => EditOrder::route('/{record}/edit'),
        ];
    }
}
