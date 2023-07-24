<?php

use DV5150\Shop\Filament\Resources\ShippingModeResource;
use DV5150\Shop\Filament\Resources\ShippingModeResource\RelationManagers\PaymentModesRelationManager;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

it('renders the resource pages', function () {
    expect(get(ShippingModeResource::getUrl('index')))->assertSuccessful()
        ->and(get(ShippingModeResource::getUrl('create')))->assertSuccessful();
});

it('renders the PaymentMode Relation Manager', function () {
    $paymentModes = config('shop.models.paymentMode')::factory()
        ->count(10)
        ->create();

    $shippingMode = config('shop.models.shippingMode')::factory()
        ->create();

    $shippingMode
        ->paymentModes()
        ->saveMany($paymentModes);

    livewire(PaymentModesRelationManager::class, [
        'ownerRecord' => $shippingMode
    ])->assertCanSeeTableRecords($paymentModes);
});