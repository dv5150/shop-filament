<?php

namespace DV5150\Shop\Filament\Resources;

use DV5150\Shop\Contracts\Deals\Discounts\DiscountContract;
use DV5150\Shop\Contracts\Models\ProductContract;
use DV5150\Shop\Filament\Resources\DiscountResource\Pages\CreateDiscount;
use DV5150\Shop\Filament\Resources\DiscountResource\Pages\EditDiscount;
use DV5150\Shop\Filament\Resources\DiscountResource\Pages\ListDiscounts;
use DV5150\Shop\Models\Deals\Discounts\ProductPercentDiscount;
use DV5150\Shop\Models\Deals\Discounts\ProductValueDiscount;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\MorphToSelect\Type;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;

class DiscountResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $slug = 'shop/discounts';

    protected static ?string $navigationGroup = 'Shop';

    protected static ?string $navigationLabel = 'Discounts';

    public static function getModel(): string
    {
        return config('shop.models.discount');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                MorphToSelect::make('discountable')
                    ->types([
                        Type::make(config('shop.models.product'))
                            ->getOptionLabelFromRecordUsing(
                                function (ProductContract $product): string {
                                    return $product->getName();
                                }
                            )->titleColumnName('name')
                            ->label('Product'),
                    ])->required()
                    ->label('Discounted Item'),
                Select::make('discount_type')
                    ->options(self::getDiscountTypes())
                    ->required(),
                Card::make([
                    TextInput::make('value')
                        ->numeric()
                        ->required(),
                    TextInput::make('name'),
                ])->relationship('discount'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('discount')
                    ->formatStateUsing(function (DiscountContract $state) {
                        return self::getDiscountAdminName($state);
                    }),
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
            'index' => ListDiscounts::route('/'),
            'create' => CreateDiscount::route('/create'),
            'edit' => EditDiscount::route('/{record}/edit'),
        ];
    }

    public static function getDiscountAdminName(DiscountContract $state): string
    {
        $name = $state->getName();

        if ($discountable = $state->getBaseDiscount()->getDiscountable()) {
            $name .= " | {$discountable->getName()}";
        }

        return $name;
    }

    protected static function getDiscountTypes(): array
    {
        return [
            ProductPercentDiscount::class => 'Percent Discount (%)',
            ProductValueDiscount::class => 'Value Discount (' . config('shop.currency.code') . ')',
        ];
    }
}
