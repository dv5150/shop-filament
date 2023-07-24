<?php

use DV5150\Shop\Filament\Resources\UserResource\RelationManagers\OrdersRelationManager;
use DV5150\Shop\Filament\Tests\Mock\Resources\UserResource;
use Illuminate\Support\Str;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

it('renders the resource pages', function () {
    expect(get(UserResource::getUrl('index')))->assertSuccessful()
        ->and(get(UserResource::getUrl('create')))->assertSuccessful();
});

it('renders the Order Relation Manager', function () {
    $user = config('shop.models.user')::factory()
        ->create();

    $orders = config('shop.models.order')::factory()
        ->count(10)
        ->create([
            'uuid' => function () {
                do {
                    $uuid = Str::uuid();
                } while (config('shop.models.order')::whereUuid($uuid)->exists());

                return $uuid;
            },
            'user_id' => $user->getKey(),
            'shipping_mode_id' => function () {
                return config('shop.models.shippingMode')::factory()
                    ->create()->getKey();
            },
            'payment_mode_id' => function () {
                return config('shop.models.paymentMode')::factory()
                    ->create()->getKey();
            },
        ]);

    livewire(OrdersRelationManager::class, [
        'ownerRecord' => $user
    ])->assertCanSeeTableRecords($orders);
});