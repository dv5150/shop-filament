<?php

namespace DV5150\Shop\Filament\Tests\Mock\Resources\UserResource\Pages;

use DV5150\Shop\Filament\Tests\Mock\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
