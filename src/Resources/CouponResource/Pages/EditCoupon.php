<?php

namespace DV5150\Shop\Filament\Resources\CouponResource\Pages;

use DV5150\Shop\Contracts\Deals\Coupons\BaseCouponContract;
use DV5150\Shop\Filament\Resources\CouponResource;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class EditCoupon extends EditRecord
{
    protected static string $resource = CouponResource::class;

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update([
            'code' => $data['code'],
        ]);

        $requiredCouponType = $data['coupon_type'];

        $newCouponData = Arr::except(
            $this->data['coupon'],
            ['id', 'created_at', 'updated_at']
        );

        $existingCartCoupon = $record->getCoupon();

        if (!$existingCartCoupon instanceof $requiredCouponType) {
            $currentCouponClass = get_class($existingCartCoupon);

            $currentCouponClass::withoutEvents(function () use ($existingCartCoupon) {
                $existingCartCoupon->delete();
            });

            tap($record, function (BaseCouponContract $baseCoupon) use ($requiredCouponType, $newCouponData) {
                $coupon = $requiredCouponType::create($newCouponData);

                $baseCoupon->coupon()->associate($coupon);
                $baseCoupon->save();
            });
        } else {
            $existingCartCoupon->update($newCouponData);
        }

        return $record;
    }

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
