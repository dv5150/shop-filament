<?php

namespace DV5150\Shop\Filament\Resources;

use DV5150\Shop\Filament\Resources\ProductResource\Pages\CreateProduct;
use DV5150\Shop\Filament\Resources\ProductResource\Pages\EditProduct;
use DV5150\Shop\Filament\Resources\ProductResource\Pages\ListProducts;
use DV5150\Shop\Filament\Resources\ProductResource\RelationManagers\DiscountsRelationManager;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;

class ProductResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'Shop';

    public static function getModel(): string
    {
        return config('shop.models.product');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                TextInput::make('price_gross')
                    ->numeric()
                    ->required()
                    ->label('Gross Price (' . config('shop.currency.code') . ')'),
                Select::make('categories')
                    ->multiple()
                    ->relationship('categories', 'name'),
                Checkbox::make('is_digital_product')
                    ->label('Is digital product?')
                    ->inline(false),
                MarkdownEditor::make('description')
                    ->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('price_gross')
                    ->label('Gross Price (' . config('shop.currency.code') . ')'),
                TextColumn::make('categories')
                    ->formatStateUsing(function ($record) {
                        $names = $record->categories->map->name;

                        return $names->isEmpty() ? '-' : $names->implode(', ');
                    }),
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
            DiscountsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }
}
