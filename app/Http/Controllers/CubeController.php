<?php

namespace App\Http\Controllers;

use App\Exceptions\NullCubeStateException;
use App\Models\Cube;
use App\Processor\CubeProcessor;
use Illuminate\Http\Resources\Json\JsonResource;

class CubeController
{
    /**
     * @return JsonResource
     */
    public function create(): JsonResource
    {
        /** @var Cube $cube */
        $cube = Cube::firstOrNew();

        $cubeProcessor = new CubeProcessor($cube->state);

        $cubeProcessor->init();

        $cube->state = $cubeProcessor->getCubeState();
        $cube->save();

        return new JsonResource($cube);
    }

    /**
     * @return JsonResource
     * @throws NullCubeStateException
     */
    public function shuffle(): JsonResource
    {
        /** @var Cube $cube */
        $cube = Cube::firstOrFail();

        $cubeProcessor = new CubeProcessor($cube->state);

        $cubeProcessor->shuffle();

        $cube->state = $cubeProcessor->getCubeState();
        $cube->save();

        return new JsonResource($cube);
    }

    /**
     * @param string $face
     * @param string $direction
     * @return JsonResource
     * @throws NullCubeStateException
     */
    public function rotate(string $face, string $direction): JsonResource
    {
        /** @var Cube $cube */
        $cube = Cube::firstOrFail();

        $cubeProcessor = new CubeProcessor($cube->state);

        $cubeProcessor->rotate($face, $direction);

        $cube->state = $cubeProcessor->getCubeState();
        $cube->save();

        return new JsonResource($cube);
    }
}
