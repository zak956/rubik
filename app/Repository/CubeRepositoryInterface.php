<?php

namespace App\Repository;

use App\Models\Cube;

interface CubeRepositoryInterface
{
    /**
     * @return Cube
     */
    public function createCube(): Cube;

    /**
     * @param Cube $cube
     * @return bool
     */
    public function saveCube(Cube &$cube): bool;
}
