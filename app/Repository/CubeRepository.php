<?php

namespace App\Repository;

use App\Models\Cube;

class CubeRepository implements CubeRepositoryInterface
{
    /**
     * @return Cube
     */
    public function createCube(): Cube
    {
        return new Cube();
    }

    /**
     * @param Cube $cube
     * @return bool
     */
    public function saveCube(Cube &$cube): bool
    {
        return $cube->save();
    }
}
