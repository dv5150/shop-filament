<?php

namespace DV5150\Shop\Filament\Resources;

use DV5150\Shop\Filament\Resources\CouponResource\Pages\CreateCoupon;
use DV5150\Shop\Filament\Resources\CouponResource\Pages\EditCoupon;
use DV5150\Shop\Filament\Resources\CouponResource\Pages\ListCoupons;
use DV5150\Shop\Contracts\Deals\Coupons\CouponContract;
use DV5150\Shop\Models\Deals\Coupons\CartPercentCoupon;
use DV5150\Shop\Models\Deals\Coupons\CartValueCoupon;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;

class CouponResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $slug = 'shop/coupons';

    protected static ?string $navigationGroup = 'Shop';

    protected static ?string $navigationLabel = 'Cart Coupon Codes';

    public static function getModel(): string
    {
        return config('shop.models.coupon');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('coupon_type')
                    ->options(self::getCouponTypes())
                    ->required()
                    ->reactive(),
                TextInput::make('code')
                    ->unique(ignoreRecord: true)
                    ->required(),
                Card::make([
                    TextInput::make('value')
                        ->numeric()
                        ->required(),
                    TextInput::make('name'),
                ])->relationship('coupon'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('coupon')
                    ->formatStateUsing(
                        fn (CouponContract $state) => $state->getName()
                    ),
                TextColumn::make('code'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
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
            'index' => ListCoupons::route('/'),
            'create' => CreateCoupon::route('/create'),
            'edit' => EditCoupon::route('/{record}/edit'),
        ];
    }

    protected static function getCouponTypes(): array
    {
        return [
            CartPercentCoupon::class => 'Cart Percent Coupon (%)',
            CartValueCoupon::class => 'Cart Value Coupon (' . config('shop.currency.code') . ')',
        ];
    }
}
