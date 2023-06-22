<?php

namespace DV5150\Shop\Filament\Resources\ProductResource\RelationManagers;

use DV5150\Shop\Contracts\Deals\Discounts\BaseDiscountContract;
use DV5150\Shop\Contracts\Deals\Discounts\DiscountContract;
use DV5150\Shop\Filament\Resources\DiscountResource;
use DV5150\Shop\Models\Deals\Discounts\ProductPercentDiscount;
use DV5150\Shop\Models\Deals\Discounts\ProductValueDiscount;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasRelationshipTable;
use Illuminate\Database\Eloquent\Model;

class DiscountsRelationManager extends RelationManager
{
    protected static string $relationship = 'discounts';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('discount')
                    ->formatStateUsing(function (DiscountContract $state) {
                        return DiscountResource::getDiscountAdminName($state);
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->using(function (HasRelationshipTable $livewire, array $data): Model {
                        $discountedItem = $livewire->ownerRecord;

                        tap(new (config('shop.models.discount')), function (BaseDiscountContract $baseDiscount) use ($discountedItem, $data) {
                            $discount = $data['discount_type']::create([
                                'name' => $data['name'],
                                'value' => $data['value'],
                            ]);

                            $baseDiscount->discountable()->associate($discountedItem);
                            $baseDiscount->discount()->associate($discount);
                            $baseDiscount->save();
                        });

                        return $discountedItem;
                    })
                    ->form([
                        Select::make('discount_type')
                            ->options(self::getDiscountTypes())
                            ->required(),
                        Card::make([
                            TextInput::make('value')
                                ->numeric()
                                ->required(),
                            TextInput::make('name'),
                        ]),
                    ])
            ])
            ->actions([
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    protected static function getDiscountTypes(): array
    {
        return [
            ProductPercentDiscount::class => 'Percent Discount (%)',
            ProductValueDiscount::class => 'Value Discount (' . config('shop.currency.code') . ')',
        ];
    }
}
