<?php

namespace DV5150\Shop\Filament\Tests\Mock\Models;

use DV5150\Shop\Filament\Tests\Mock\Factories\OrderFactory;
use DV5150\Shop\Models\Default\Order as ShopOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends ShopOrder
{
    use HasFactory;

    protected static function newFactory()
    {
        return OrderFactory::new();
    }
}