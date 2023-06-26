<?php

namespace DV5150\Shop\Filament\Resources\ProductResource\RelationManagers;

use DV5150\Shop\Contracts\Deals\Discounts\BaseDiscountContract;
use DV5150\Shop\Contracts\Deals\Discounts\DiscountContract;
use DV5150\Shop\Filament\Resources\DiscountResource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\DetachAction;
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
                    ->formatStateUsing(fn (DiscountContract $state) => $state->getName()),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make()
                    ->recordSelect(fn (Select $select) => $select->options(
                        config('shop.models.discount')::with('discount')
                            ->get()
                            ->mapWithKeys(fn (BaseDiscountContract $discount) => [
                                $discount->getKey() => $discount->getDiscount()->getName()
                            ])
                    )),
                CreateAction::make()
                    ->using(function (HasRelationshipTable $livewire, array $data): Model {

                        /** @var BaseDiscountContract $discount */
                        $discount = tap(
                            new (config('shop.models.discount')),
                            function (BaseDiscountContract $baseDiscount) use ($data) {
                                $discount = $data['discount_type']::create([
                                    'name' => $data['name'],
                                    'value' => $data['value'],
                                ]);

                                $baseDiscount->discount()->associate($discount);
                                $baseDiscount->save();
                            }
                        );

                        $livewire->ownerRecord->discounts()->sync($discount);

                        return $livewire->ownerRecord->load('discounts');
                    })
                    ->form([
                        Select::make('discount_type')
                            ->options(DiscountResource::getDiscountTypes())
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
                DetachAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }
}
