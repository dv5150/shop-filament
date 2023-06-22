<?php

namespace DV5150\Shop\Filament;

use DV5150\Shop\Filament\Resources\CouponResource;
use DV5150\Shop\Filament\Resources\DiscountResource;
use DV5150\Shop\Filament\Resources\OrderResource;
use DV5150\Shop\Filament\Resources\PaymentModeResource;
use DV5150\Shop\Filament\Resources\ProductResource;
use DV5150\Shop\Filament\Resources\ShippingModeResource;
use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class ShopFilamentServiceProvider extends PluginServiceProvider
{
    protected array $resources = [
        CouponResource::class,
        DiscountResource::class,
        OrderResource::class,
        PaymentModeResource::class,
        ProductResource::class,
        ShippingModeResource::class,
    ];

    public function configurePackage(Package $package): void
    {
        $package->name('shop-filament');
    }
}