<?php

namespace DV5150\Shop\Filament\Tests\Mock\Providers;

use DV5150\Shop\Filament\Resources\CouponResource;
use DV5150\Shop\Filament\Resources\DiscountResource;
use DV5150\Shop\Filament\Resources\OrderResource;
use DV5150\Shop\Filament\Resources\PaymentModeResource;
use DV5150\Shop\Filament\Resources\ProductResource;
use DV5150\Shop\Filament\Resources\ShippingModeResource;
use DV5150\Shop\Filament\ShopFilamentServiceProvider;
use DV5150\Shop\Filament\Tests\Mock\Resources\UserResource;

class MockServiceProvider extends ShopFilamentServiceProvider
{
    protected array $resources = [
        CouponResource::class,
        DiscountResource::class,
        OrderResource::class,
        PaymentModeResource::class,
        ProductResource::class,
        ShippingModeResource::class,
        UserResource::class,
    ];
}