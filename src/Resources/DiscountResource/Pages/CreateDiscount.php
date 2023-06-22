<?php

namespace DV5150\Shop\Filament\Resources\DiscountResource\Pages;

use DV5150\Shop\Contracts\Deals\Discounts\BaseDiscountContract;
use DV5150\Shop\Filament\Resources\DiscountResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateDiscount extends CreateRecord
{
    protected static string $resource = DiscountResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $data = $this->data;

        $discount = $data['discount_type']::create($data['discount']);

        $baseDiscount = tap(new (config('shop.models.discount'))([
            'discountable_type' => $data['discountable_type'],
            'discountable_id' => $data['discountable_id'],
        ]), function (BaseDiscountContract $baseDiscount) use ($discount) {
            $baseDiscount->discount()->associate($discount);
        });

        $baseDiscount->save();

        return $baseDiscount;
    }
}
