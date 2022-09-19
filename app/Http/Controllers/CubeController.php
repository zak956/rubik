<?php

namespace App\Http\Controllers;

use App\Enums\Faces;
use App\Enums\Directions;
use App\Managers\CubeManager;
use App\Models\Cube;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Cube as CubeResource;

class CubeController
{
    public function __construct(protected CubeManager $cubeManager)
    {
    }

    /**
     * @return JsonResource
     */
    public function create(): JsonResource
    {
        return new CubeResource($this->cubeManager->create());
    }

    /**
     * @param Cube $cube
     * @return JsonResource
     */
    public function get(Cube $cube): JsonResource
    {
        return new CubeResource($cube);
    }

    /**
     * @param Cube $cube
     * @return JsonResource
     */
    public function init(Cube $cube): JsonResource
    {
        return new CubeResource($this->cubeManager->init($cube));
    }

    /**
     * @param Cube $cube
     * @return JsonResource
     */
    public function shuffle(Cube $cube): JsonResource
    {
        return new CubeResource($this->cubeManager->shuffle($cube));
    }

    /**
     * @param Cube $cube
     * @param Faces $face
     * @param Directions $direction
     * @return JsonResource
     */
    public function rotate(Cube $cube, Faces $face, Directions $direction): JsonResource
    {
        return new CubeResource($this->cubeManager->rotate($cube, $face, $direction));
    }
}
