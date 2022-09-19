<?php

namespace Database\Seeders;

use App\Models\Cube;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         Cube::factory(1)->create();
    }
}
