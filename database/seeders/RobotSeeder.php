<?php

namespace Database\Seeders;

use App\Models\Robot;
use Illuminate\Database\Seeder;

class RobotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Robot::factory(15)->create();
    }
}
