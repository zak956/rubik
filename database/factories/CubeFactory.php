<?php

namespace Database\Factories;

use App\Models\Cube;
use App\Processors\CubeProcessor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cube>
 */
class CubeFactory extends Factory
{
    public function definition()
    {
        return [
            'state' => CubeProcessor::getDefaultState(),
        ];
    }
}
