<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    protected $model = Order::class;
    public function definition(): array
    {
        return [
            'delivery_date' => Carbon::now(),
            'freight_value' => fake()->randomFloat(2,0,2000),
            'user_id' => function () {
                return User::factory()->create()->id;
            },
        ];
    }
}
