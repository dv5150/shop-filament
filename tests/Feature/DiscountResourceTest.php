<?php

use DV5150\Shop\Contracts\Deals\Discounts\BaseDiscountContract;
use DV5150\Shop\Contracts\Deals\Discounts\DiscountContract;
use DV5150\Shop\Contracts\Models\SellableItemContract;
use DV5150\Shop\Filament\Resources\DiscountResource;
use DV5150\Shop\Filament\Resources\DiscountResource\RelationManagers\ProductsRelationManager;
use DV5150\Shop\Tests\Mock\Models\Deals\Discount;
use DV5150\Shop\Tests\Mock\Models\Deals\Discounts\ProductPercentDiscount;
use DV5150\Shop\Tests\Mock\Models\Deals\Discounts\ProductValueDiscount;
use Illuminate\Database\Eloquent\Collection;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

it('renders the resource pages', function () {
    expect(get(DiscountResource::getUrl('index')))->assertSuccessful()
        ->and(get(DiscountResource::getUrl('create')))->assertSuccessful();
});

it('renders the Products Relation Manager', function () {
    /** @var SellableItemContract $productA */
    $productA = config('shop.models.product')::factory()
        ->create();

    /** @var SellableItemContract $productA */
    $productB = config('shop.models.product')::factory()
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

    $productA->discounts()->sync($discounts->modelKeys());
    $productB->discounts()->sync($discounts->modelKeys());

    livewire(ProductsRelationManager::class, [
        'ownerRecord' => $discountA
    ])->assertCanSeeTableRecords(new Collection([$productA, $productB]));

    livewire(ProductsRelationManager::class, [
        'ownerRecord' => $discountB
    ])->assertCanSeeTableRecords(new Collection([$productA, $productB]));
});