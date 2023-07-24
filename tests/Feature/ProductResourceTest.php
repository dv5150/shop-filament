<?php

use DV5150\Shop\Contracts\Deals\Discounts\BaseDiscountContract;
use DV5150\Shop\Contracts\Deals\Discounts\DiscountContract;
use DV5150\Shop\Contracts\Models\SellableItemContract;
use DV5150\Shop\Filament\Resources\ProductResource;
use DV5150\Shop\Filament\Resources\ProductResource\RelationManagers\DiscountsRelationManager;
use DV5150\Shop\Tests\Mock\Models\Deals\Discount;
use DV5150\Shop\Tests\Mock\Models\Deals\Discounts\ProductPercentDiscount;
use DV5150\Shop\Tests\Mock\Models\Deals\Discounts\ProductValueDiscount;
use Illuminate\Database\Eloquent\Collection;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

it('renders the resource pages', function () {
    expect(get(ProductResource::getUrl('index')))->assertSuccessful()
        ->and(get(ProductResource::getUrl('create')))->assertSuccessful();
});

it('renders the Discounts Relation Manager', function () {
    /** @var SellableItemContract $product */
    $product = config('shop.models.product')::factory()
        ->create();

    $discountA = ProductPercentDiscount::factory()
        ->afterCreating(function (DiscountContract $discount) {
            /** @var BaseDiscountContract $baseDiscount */
            $baseDiscount = Discount::factory()->make();
            $baseDiscount->discount()->associate($discount);
            $baseDiscount->save();
        })
        ->create([
            'name' => '60% OFF discount',
            'value' => 60.0,
        ])->getBaseDiscount();

    $discountB = ProductValueDiscount::factory()
        ->afterCreating(function (DiscountContract $discount) {
            /** @var BaseDiscountContract $baseDiscount */
            $baseDiscount = Discount::factory()->make();
            $baseDiscount->discount()->associate($discount);
            $baseDiscount->save();
        })
        ->create([
            'name' => '700 OFF discount',
            'value' => 700.0,
        ])->getBaseDiscount();

    $discounts = new Collection([$discountA, $discountB]);

    $product->discounts()->sync($discounts->modelKeys());

    livewire(DiscountsRelationManager::class, [
        'ownerRecord' => $product
    ])->assertCanSeeTableRecords($discounts);
});