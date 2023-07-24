<?php

namespace DV5150\Shop\Filament\Tests\Mock\Factories;

use DV5150\Shop\Filament\Tests\Mock\Models\User;
use DV5150\Shop\Tests\Mock\Factories\UserFactory;

class FilamentUserFactory extends UserFactory
{
    protected $model = User::class;
}