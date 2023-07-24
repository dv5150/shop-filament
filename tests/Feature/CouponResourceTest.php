<?php

use DV5150\Shop\Filament\Resources\CouponResource;
use function Pest\Laravel\get;

it('renders the resource pages', function () {
    expect(get(CouponResource::getUrl('index')))->assertSuccessful()
        ->and(get(CouponResource::getUrl('create')))->assertSuccessful();
});