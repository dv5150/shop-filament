<?php

namespace DV5150\Shop\Filament\Tests\Mock\Factories;

use DV5150\Shop\Filament\Tests\Mock\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'email' => $this->faker->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'comment' => $this->faker->realText(255),
            'shipping_name' => $this->faker->name(),
            'shipping_zip_code' => $this->faker->postcode(),
            'shipping_city' => $this->faker->city(),
            'shipping_address' => $this->faker->streetAddress(),
            'shipping_comment' => $this->faker->realText(255),
            'billing_name' => $this->faker->name(),
            'billing_zip_code' => $this->faker->postcode(),
            'billing_city' => $this->faker->city(),
            'billing_address' => $this->faker->streetAddress(),
            'billing_tax_number' => $this->faker->creditCardNumber(),
        ];
    }
}