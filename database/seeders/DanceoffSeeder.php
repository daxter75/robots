<?php

namespace Database\Seeders;

use App\Models\Danceoff;
use Illuminate\Database\Seeder;

class DanceoffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Danceoff::factory(5)->create();
    }
}
