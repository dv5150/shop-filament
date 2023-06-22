<?php

namespace DV5150\Shop\Filament\Resources\CouponResource\Pages;

use DV5150\Shop\Contracts\Deals\Coupons\BaseCouponContract;
use DV5150\Shop\Filament\Resources\CouponResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateCoupon extends CreateRecord
{
    protected static string $resource = CouponResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $data = $this->data;

        $coupon = $data['coupon_type']::create($data['coupon']);

        $baseCoupon = tap(new (config('shop.models.coupon'))([
            'code' => $data['code']
        ]), function (BaseCouponContract $baseCoupon) use ($coupon) {
            $baseCoupon->coupon()->associate($coupon);
        });

        $baseCoupon->save();

        return $baseCoupon;
    }
}
