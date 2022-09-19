<?php

namespace App\Processors;

use App\Enums\Directions;
use App\Enums\Faces;

interface CubeProcessorInterface
{
    /**
     * @param array|null $cubeState
     * @return void
     */
    public function setCubeState(?array $cubeState):void;

    /**
     * @return array
     */
    public function getCubeState(): array;

    /**
     * @return void
     */
    public function init(): void;

    /**
     * @return void
     */
    public function shuffle(): void;

    /**
     * @param Faces $face
     * @param Directions $direction
     * @return void
     */
    public function rotate(Faces $face, Directions $direction): void;
}
