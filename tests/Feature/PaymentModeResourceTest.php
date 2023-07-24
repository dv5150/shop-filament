<?php

use DV5150\Shop\Filament\Resources\PaymentModeResource;
use function Pest\Laravel\get;

it('renders the resource pages', function () {
    expect(get(PaymentModeResource::getUrl('index')))->assertSuccessful()
        ->and(get(PaymentModeResource::getUrl('create')))->assertSuccessful();
});