<?php

namespace DV5150\Shop\Filament\Resources\DiscountResource\Pages;

use DV5150\Shop\Contracts\Deals\Discounts\BaseDiscountContract;
use DV5150\Shop\Contracts\Deals\Discounts\DiscountContract;
use DV5150\Shop\Filament\Resources\DiscountResource;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class EditDiscount extends EditRecord
{
    protected static string $resource = DiscountResource::class;

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        /** @var DiscountContract $requiredDiscountType */
        $requiredDiscountType = $data['discount_type'];

        $newDiscountData = Arr::except(
            $this->data['discount'],
            ['id', 'created_at', 'updated_at']
        );

        $existingProductDiscount = $record->getDiscount();

        if (!$existingProductDiscount instanceof $requiredDiscountType) {
            /** @var Model $currentDiscountClass */
            $currentDiscountClass = get_class($existingProductDiscount);

            $currentDiscountClass::withoutEvents(function () use ($existingProductDiscount) {
                $existingProductDiscount->delete();
            });

            tap($record, function (BaseDiscountContract $baseDiscount) use ($requiredDiscountType, $newDiscountData) {
                $discount = $requiredDiscountType::create($newDiscountData);

                $baseDiscount->discount()->associate($discount);
                $baseDiscount->save();
            });
        } else {
            $existingProductDiscount->update($newDiscountData);
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
