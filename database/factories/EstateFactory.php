<?php

namespace Database\Factories;

use App\Models\Estate;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EstateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Estate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => "{$this->faker->city()}: {$this->faker->sentence()} mansion"
        ];
    }
}
