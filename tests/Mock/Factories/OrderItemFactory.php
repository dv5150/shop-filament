<?php

namespace DV5150\Shop\Filament\Tests\Mock\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'quantity' => $this->faker->numberBetween(1, 10),
            'price_gross' => (float) ($this->faker->numberBetween(9, 99) * 100 + 90),
            'info' => $this->faker->realText(255),
        ];
    }
}