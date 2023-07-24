<?php

namespace DV5150\Shop\Filament\Tests\Mock\Models;

use DV5150\Shop\Filament\Tests\Mock\Factories\FilamentUserFactory;
use DV5150\Shop\Tests\Mock\Models\User as ShopUser;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class User extends ShopUser implements FilamentUser
{
    public function canAccessFilament(): bool
    {
        return true;
    }

    public static function newFactory(): Factory
    {
        return FilamentUserFactory::new();
    }
}