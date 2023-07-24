<?php

namespace DV5150\Shop\Filament\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use DV5150\Shop\Filament\Tests\Mock\Models\Order;
use DV5150\Shop\Filament\Tests\Mock\Models\OrderItem;
use DV5150\Shop\Filament\Tests\Mock\Models\User;
use DV5150\Shop\Filament\Tests\Mock\Providers\MockServiceProvider;
use DV5150\Shop\ShopServiceProvider;
use DV5150\Shop\Support\ShopItemCapsule;
use DV5150\Shop\Tests\Mock\Models\PaymentMode;
use DV5150\Shop\Tests\Mock\Models\Product;
use DV5150\Shop\Tests\Mock\Models\ShippingMode;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(config('shop.models.user')::factory()->create());
    }

    protected function getPackageProviders($app)
    {
        return [
            ShopServiceProvider::class,

            BladeCaptureDirectiveServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeIconsServiceProvider::class,
            FilamentServiceProvider::class,
            FormsServiceProvider::class,
            LivewireServiceProvider::class,
            NotificationsServiceProvider::class,
            SupportServiceProvider::class,
            TablesServiceProvider::class,

            MockServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('shop.models.user', User::class);
        $app['config']->set('shop.models.order', Order::class);
        $app['config']->set('shop.models.orderitem', OrderItem::class);
        $app['config']->set('shop.models.product', Product::class);
        $app['config']->set('shop.models.paymentMode', PaymentMode::class);
        $app['config']->set('shop.models.shippingMode', ShippingMode::class);

        $app['config']->set('shop.support.shopItemCapsule', ShopItemCapsule::class);
    }


    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(realpath(__DIR__ . '/../vendor/dv5150/shop/database/migrations'));
    }
}