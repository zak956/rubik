<?php

namespace App\Managers;

use App\Enums\Directions;
use App\Enums\Faces;
use App\Models\Cube;
use App\Processors\CubeProcessorInterface;
use App\Repository\CubeRepositoryInterface;

class CubeManager
{
    /**
     * @param CubeProcessorInterface $cubeProcessor
     * @param CubeRepositoryInterface $cubeRepository
     */
    public function __construct(
        protected CubeProcessorInterface $cubeProcessor,
        protected CubeRepositoryInterface $cubeRepository
    ) {
    }

    /**
     * @return Cube
     */
    public function create(): Cube
    {
        $cube = $this->cubeRepository->createCube();
        return $this->init($cube);
    }

    /**
     * @param Cube $cube
     * @return Cube
     */
    public function init(Cube $cube): Cube
    {
        $this->cubeProcessor->setCubeState($cube->state);
        $this->cubeProcessor->init();
        $cube->state = $this->cubeProcessor->getCubeState();
        $this->cubeRepository->saveCube($cube);
        return $cube;
    }

    /**
     * @param Cube $cube
     * @return Cube
     */
    public function shuffle(Cube $cube): Cube
    {
        $this->cubeProcessor->setCubeState($cube->state);
        $this->cubeProcessor->shuffle();
        $cube->state = $this->cubeProcessor->getCubeState();
        $this->cubeRepository->saveCube($cube);
        return $cube;
    }

    /**
     * @param Cube $cube
     * @param Faces $face
     * @param Directions $direction
     * @return Cube
     */
    public function rotate(Cube $cube, Faces $face, Directions $direction): Cube
    {
        $this->cubeProcessor->setCubeState($cube->state);
        $this->cubeProcessor->rotate($face, $direction);
        $cube->state = $this->cubeProcessor->getCubeState();
        $this->cubeRepository->saveCube($cube);
        return $cube;
    }
}
