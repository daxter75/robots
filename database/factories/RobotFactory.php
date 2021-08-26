<?php

namespace Database\Factories;

use App\Models\Robot;
use Illuminate\Database\Eloquent\Factories\Factory;

class RobotFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Robot::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          'name' => $this->faker->name,
          'powermove' => $this->faker->word(),
          'experience' => $this->faker->randomDigitNotNull,
          'avatar' => 'https://robohash.org/' . $this->faker->slug(2) . '.png',
        ];
    }
}
