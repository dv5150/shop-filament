<?php

namespace DV5150\Shop\Filament\Resources\OrderResource\RelationManagers;

use DV5150\Shop\Filament\Resources\ProductResource;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\DB;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $recordTitleAttribute = 'name';

    public function getRelationship(): Relation | Builder
    {
        return $this->getOwnerRecord()
            ->{static::getRelationshipName()}()
            ->with('product')
            ->select(['*', DB::raw('(quantity * price_gross) as subtotal')]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->disabled(),
                TextInput::make('price_gross')
                    ->disabled()
                    ->label('Gross Price (' . config('shop.currency.code') . ')'),
                TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->minValue(1)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('quantity'),
                TextColumn::make('price_gross')
                    ->label('Gross Price (' . config('shop.currency.code') . ')'),
                TextColumn::make('subtotal'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                Action::make('viewItem')
                    ->label('View Item')
                    ->visible(fn ($record) => $record->product)
                    ->url(fn ($record) => ProductResource::getUrl('edit', [
                        'record' => $record->product
                    ]))
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-eye'),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }
}
