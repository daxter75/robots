<?php

namespace Database\Factories;

use App\Models\Danceoff;
use Illuminate\Database\Eloquent\Factories\Factory;

class DanceoffFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Danceoff::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
      $winner = $this->faker->numberBetween(2, 15);
      $loser = $winner-1;
      return [
          'winner' => $winner,
          'loser' => $loser,
      ];
    }
}
