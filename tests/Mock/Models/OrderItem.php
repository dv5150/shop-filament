<?php

namespace DV5150\Shop\Filament\Tests\Mock\Models;

use DV5150\Shop\Filament\Tests\Mock\Factories\OrderItemFactory;
use DV5150\Shop\Models\Default\OrderItem as ShopOrderItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends ShopOrderItem
{
    use HasFactory;

    protected static function newFactory()
    {
        return OrderItemFactory::new();
    }
}