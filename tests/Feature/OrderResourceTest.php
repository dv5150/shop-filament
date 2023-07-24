<?php

use DV5150\Shop\Contracts\Models\OrderContract;
use DV5150\Shop\Contracts\Models\SellableItemContract;
use DV5150\Shop\Contracts\Models\ShippingModeContract;
use DV5150\Shop\Filament\Resources\OrderResource;
use DV5150\Shop\Filament\Resources\OrderResource\RelationManagers\ItemsRelationManager;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Livewire\livewire;

it('renders the resource pages', function () {
    expect(get(OrderResource::getUrl('index')))->assertSuccessful()
        ->and(get(OrderResource::getUrl('create')))->assertSuccessful();
});

it('renders the Order Item Relation Manager', function () {
    list($productA, $productB) = config('shop.models.product')::factory()
        ->count(2)
        ->create()
        ->all();

    /** @var ShippingModeContract $shippingMode */
    $shippingMode = config('shop.models.shippingMode')::factory()
        ->create();

    $shippingMode
        ->paymentModes()
        ->sync(config('shop.models.paymentMode')::factory()->create());

    post(route('api.shop.checkout.store'), array_merge(
        [
            'personalData' => [
                'email' => 'tester+mailaddress+10000@my-webshop.com',
                'phone' => '+36301001000',
            ],
            'shippingData' => [
                'name' => 'Test Name 1000',
                'zipCode' => '1000',
                'city' => 'Budapest 1000',
                'street' => 'One street 1000',
            ],
            'billingData' => [
                'name' => 'Another Name 9000',
                'zipCode' => '9000',
                'city' => 'Győr 9000',
                'street' => 'Street 9000',
            ],
        ],
        [
            'cartData' => [
                [
                    'item' => ['id' => $productA->getKey()],
                    'quantity' => 2,
                ],
                [
                    'item' => ['id' => $productB->getKey()],
                    'quantity' => 4,
                ]
            ],
            'shippingMode' => [
                'provider' => $shippingMode->getProvider(),
            ],
            'paymentMode' => [
                'provider' => $shippingMode->paymentModes()->first()->getProvider(),
            ],
        ]));

    /** @var OrderContract $order */
    $order = config('shop.models.order')::first();

    livewire(ItemsRelationManager::class, [
        'ownerRecord' => $order
    ])->assertCanSeeTableRecords($order->items);
});