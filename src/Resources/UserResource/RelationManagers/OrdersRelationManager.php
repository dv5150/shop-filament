<?php

namespace DV5150\Shop\Filament\Resources\UserResource\RelationManagers;

use DV5150\Shop\Filament\Resources\OrderResource;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';

    protected static ?string $recordTitleAttribute = 'created_at';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('created_at')
                    ->required()
                    ->maxLength(255),
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
                    ->label('Total'),
                TextColumn::make('created_at')
                    ->label('Date'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->actions([
                Action::make('viewOrder')
                    ->label('View Order')
                    ->url(fn ($record) => OrderResource::getUrl('edit', [
                        'record' => $record
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
