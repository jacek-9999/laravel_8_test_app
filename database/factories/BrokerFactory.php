<?php

namespace Database\Factories;

use App\Models\Broker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BrokerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Broker::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => ucfirst($this->faker->sentence(3))
        ];
    }
}
