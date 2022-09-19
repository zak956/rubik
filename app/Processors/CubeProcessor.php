<?php

namespace App\Processors;

use App\Enums\Colors;
use App\Enums\Faces;
use App\Enums\Directions;
use App\Exceptions\NullCubeStateException;
use App\Models\Cube;
use Exception;

class CubeProcessor implements CubeProcessorInterface
{
    /** @var array|null  */
    private ?array $cubeState = null;

    /**
     * @param array|null $cubeState
     * @return void
     */
    public function setCubeState(?array $cubeState): void
    {
        $this->cubeState = $cubeState;
    }

    /**
     * @return array
     */
    public static function getDefaultState(): array
    {
        $state = [];

        $initialColors = [
            Faces::FACE_FRONT => Colors::COLOR_BLUE,
            Faces::FACE_RIGHT => Colors::COLOR_WHITE,
            Faces::FACE_BACK => Colors::COLOR_RED,
            Faces::FACE_LEFT => Colors::COLOR_ORANGE,
            Faces::FACE_TOP => Colors::COLOR_GREEN,
            Faces::FACE_BOTTOM => Colors::COLOR_YELLOW
        ];

        foreach (Faces::getValues() as $face) {
            for ($i = 0; $i < Cube::CUBE_SIZE; $i++) {
                for ($j = 0; $j < Cube::CUBE_SIZE; $j++) {
                    $state[$face][$i][$j] = $initialColors[$face];
                }
            }
        }

        return $state;
    }

    /**
     * @return array
     */
    public function getCubeState(): array
    {
        return $this->cubeState;
    }

    /**
     * @return void
     */
    public function init(): void
    {
        $this->cubeState = self::getDefaultState();
    }

    /**
     * @param int $times
     * @return void
     * @throws NullCubeStateException
     * @throws Exception
     */
    public function shuffle(int $times = 20): void
    {
        if (null === $this->cubeState) {
            throw new NullCubeStateException('Cube state is empty. Must be initialized first.');
        }

        for ($i = 0; $i < $times; $i++) {
            $this->doRotateCW(Faces::getRandomValue());
        }
    }

    /**
     * @param Faces $face
     * @param Directions $direction
     * @return void
     * @throws NullCubeStateException
     */
    public function rotate(Faces $face, Directions $direction): void
    {
        if (null === $this->cubeState) {
            throw new NullCubeStateException('Cube state is empty. Must be initialized first.');
        }

        $this->doRotateCW($face);
        if ($direction->is(Directions::DIRECTION_CCW)) {
            $this->doRotateCW($face);
            $this->doRotateCW($face);
        }
    }

    /**
     * @param string $face
     * @return void
     */
    private function doRotateCW(string $face): void
    {
        $this->rotateFace($face);
        $neighbors = $this->getNeighbors($face);
        $this->rotateNeighbors($neighbors);
    }

    /**
     * @param array $neighbors
     * @return void
     */
    private function rotateNeighbors(array $neighbors): void
    {
        $tempArray = null;
        foreach ($neighbors as $faceKey => $definitions) {
            $nextDefinitions = $neighbors[$definitions['next']];
            $currentArray = null === $tempArray ? $this->getShiftArray(
                $faceKey,
                $definitions['shift'],
                $definitions['index']
            ) : $tempArray;
            $tempArray = $this->getShiftArray(
                $definitions['next'],
                $nextDefinitions['shift'],
                $nextDefinitions['index']
            );

            $this->shiftFace(
                $definitions['next'],
                $nextDefinitions['shift'],
                $nextDefinitions['index'],
                $currentArray
            );
        }
    }

    /**
     * @param string $face
     * @param string $shift
     * @param int $index
     * @return array
     */
    private function getShiftArray(string $face, string $shift, int $index): array
    {
        $arr = [];
        if ($shift === 'row') {
            $arr = $this->cubeState[$face][$index];
        } elseif ($shift === 'column') {
            foreach ($this->cubeState[$face] as $row) {
                $arr[] = $row[$index];
            }
        }

        return $arr;
    }

    /**
     * @param string $face
     * @param string $shift
     * @param int $index
     * @param array $shiftArray
     * @return void
     */
    private function shiftFace(string $face, string $shift, int $index, array $shiftArray): void
    {
        if ($shift === 'row') {
            $this->putShiftRow($face, $index, $shiftArray);
        } elseif ($shift === 'column') {
            $this->putShiftColumn($face, $index, $shiftArray);
        }
    }

    /**
     * @param string $face
     * @param int $index
     * @param array $shiftArray
     * @return void
     */
    private function putShiftRow(string $face, int $index, array $shiftArray): void
    {
        $this->cubeState[$face][$index] = $shiftArray;
    }

    /**
     * @param string $face
     * @param int $index
     * @param array $shiftArray
     * @return void
     */
    private function putShiftColumn(string $face, int $index, array $shiftArray): void
    {
        foreach ($this->cubeState[$face] as $rowIndex => $row) {
            $this->cubeState[$face][$rowIndex][$index] = $shiftArray[$index];
        }
    }

    /**
     * @param string $face
     * @return array[]
     */
    private function getNeighbors(string $face): array
    {
        $neighbors = [
            Faces::FACE_FRONT => [
                Faces::FACE_TOP => [
                    'shift' => 'row',
                    'index' => Cube::CUBE_SIZE - 1,
                    'direction' => true,
                    'next' => Faces::FACE_RIGHT
                ],
                Faces::FACE_RIGHT => [
                    'shift' => 'column',
                    'index' => 0,
                    'direction' => true,
                    'next' => Faces::FACE_BOTTOM
                ],
                Faces::FACE_BOTTOM => [
                    'shift' => 'row',
                    'index' => 0,
                    'direction' => false,
                    'next' => Faces::FACE_LEFT
                ],
                Faces::FACE_LEFT => [
                    'shift' => 'column',
                    'index' => Cube::CUBE_SIZE - 1,
                    'direction' => false,
                    'next' => Faces::FACE_TOP
                ],
            ],
            Faces::FACE_BACK => [
                Faces::FACE_TOP => [
                    'shift' => 'row',
                    'index' => 0,
                    'direction' => false,
                    'next' => Faces::FACE_RIGHT
                ],
                Faces::FACE_LEFT => [
                    'shift' => 'column',
                    'index' => Cube::CUBE_SIZE - 1,
                    'direction' => true,
                    'next' => Faces::FACE_TOP
                ],
                Faces::FACE_BOTTOM => [
                    'shift' => 'row',
                    'index' => Cube::CUBE_SIZE - 1,
                    'direction' => true,
                    'next' => Faces::FACE_LEFT
                ],
                Faces::FACE_RIGHT => [
                    'shift' => 'column',
                    'index' => 0,
                    'direction' => false,
                    'next' => Faces::FACE_BOTTOM
                ],
            ],
            Faces::FACE_LEFT => [
                Faces::FACE_TOP => [
                    'shift' => 'column',
                    'index' => 0,
                    'direction' => true,
                    'next' => Faces::FACE_FRONT
                ],
                Faces::FACE_FRONT => [
                    'shift' => 'column',
                    'index' => 0,
                    'direction' => true,
                    'next' => Faces::FACE_BOTTOM
                ],
                Faces::FACE_BOTTOM => [
                    'shift' => 'column',
                    'index' => 0,
                    'direction' => true,
                    'next' => Faces::FACE_BACK
                ],
                Faces::FACE_BACK => [
                    'shift' => 'column',
                    'index' => Cube::CUBE_SIZE - 1,
                    'direction' => false,
                    'next' => Faces::FACE_TOP
                ],
            ],
            Faces::FACE_RIGHT => [
                Faces::FACE_TOP => [
                    'shift' => 'column',
                    'index' => Cube::CUBE_SIZE - 1,
                    'direction' => true,
                    'next' => Faces::FACE_BACK
                ],
                Faces::FACE_BACK => [
                    'shift' => 'column',
                    'index' => 0,
                    'direction' => false,
                    'next' => Faces::FACE_BOTTOM
                ],
                Faces::FACE_BOTTOM => [
                    'shift' => 'column',
                    'index' => Cube::CUBE_SIZE - 1,
                    'direction' => true,
                    'next' => Faces::FACE_FRONT
                ],
                Faces::FACE_FRONT => [
                    'shift' => 'column',
                    'index' => Cube::CUBE_SIZE - 1,
                    'direction' => true,
                    'next' => Faces::FACE_TOP
                ],
            ],
            Faces::FACE_TOP => [
                Faces::FACE_FRONT => [
                    'shift' => 'row',
                    'index' => 0,
                    'direction' => false,
                    'next' => Faces::FACE_LEFT
                ],
                Faces::FACE_LEFT => [
                    'shift' => 'row',
                    'index' => 0,
                    'direction' => false,
                    'next' => Faces::FACE_BACK
                ],
                Faces::FACE_BACK => [
                    'shift' => 'row',
                    'index' => 0,
                    'direction' => false,
                    'next' => Faces::FACE_RIGHT
                ],
                Faces::FACE_RIGHT => [
                    'shift' => 'row',
                    'index' => 0,
                    'direction' => false,
                    'next' => Faces::FACE_FRONT
                ],
            ],
            Faces::FACE_BOTTOM => [
                Faces::FACE_FRONT => [
                    'shift' => 'row',
                    'index' => Cube::CUBE_SIZE - 1,
                    'direction' => true,
                    'next' => Faces::FACE_LEFT
                ],
                Faces::FACE_RIGHT => [
                    'shift' => 'row',
                    'index' => Cube::CUBE_SIZE - 1,
                    'direction' => true,
                    'next' => Faces::FACE_FRONT
                ],
                Faces::FACE_BACK => [
                    'shift' => 'row',
                    'index' => Cube::CUBE_SIZE - 1,
                    'direction' => true,
                    'next' => Faces::FACE_RIGHT
                ],
                Faces::FACE_LEFT => [
                    'shift' => 'row',
                    'index' => Cube::CUBE_SIZE - 1,
                    'direction' => true,
                    'next' => Faces::FACE_BACK
                ],
            ],
        ];

        return $neighbors[$face];
    }

    /**
     * @param string $face
     * @return void
     */
    private function rotateFace(string $face): void
    {
        $newFace = [];

        foreach ($this->cubeState[$face] as $rowIndex => $row) {
            foreach ($row as $colIndex => $cell) {
                $newFace[$colIndex][$rowIndex] = $cell;
            }
        }

        $this->cubeState[$face] = $newFace;
    }
}
