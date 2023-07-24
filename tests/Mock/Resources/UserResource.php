<?php

namespace DV5150\Shop\Filament\Tests\Mock\Resources;

use DV5150\Shop\Filament\Tests\Mock\Resources\UserResource\Pages\CreateUser;
use DV5150\Shop\Filament\Tests\Mock\Resources\UserResource\Pages\EditUser;
use DV5150\Shop\Filament\Tests\Mock\Resources\UserResource\Pages\ListUsers;
use DV5150\Shop\Filament\Resources\UserResource\RelationManagers\OrdersRelationManager;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;

class UserResource extends Resource
{
    protected static ?string $slug = 'shop/users';

    protected static ?string $navigationGroup = 'Shop';

    public static function getModel(): string
    {
        return config('shop.models.user');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                TextInput::make('email'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            OrdersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
