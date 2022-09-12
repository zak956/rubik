<?php

namespace App\Processor;

use App\Exceptions\NullCubeStateException;
use App\Models\Cube;
use Exception;

class CubeProcessor
{
    public const DIRECTION_CW = 'cw';
    public const DIRECTION_CCW = 'ccw';

    public function __construct(private ?array $cubeState)
    {
    }

    public static function getDefaultState(): array
    {
        $state = [];

        $initialColors = [
            Cube::FACE_FRONT => Cube::COLOR_BLUE,
            Cube::FACE_RIGHT => Cube::COLOR_WHITE,
            Cube::FACE_BACK => Cube::COLOR_RED,
            Cube::FACE_LEFT => Cube::COLOR_ORANGE,
            Cube::FACE_TOP => Cube::COLOR_GREEN,
            Cube::FACE_BOTTOM => Cube::COLOR_YELLOW
        ];

        foreach (Cube::FACES as $face) {
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
     * @return void
     * @throws NullCubeStateException
     * @throws Exception
     */
    public function shuffle(): void
    {
        if (null === $this->cubeState) {
            throw new NullCubeStateException('Cube state is empty. Must be initialized first.');
        }

        for ($i = 0; $i < random_int(10, 20); $i++) {
            $this->doRotateCW(Cube::FACES[random_int(0, 5)]);
        }
    }

    /**
     * @param string $face
     * @param string $direction
     * @return void
     * @throws NullCubeStateException
     */
    public function rotate(string $face, string $direction): void
    {
        if (null === $this->cubeState) {
            throw new NullCubeStateException('Cube state is empty. Must be initialized first.');
        }

        $this->doRotateCW($face);
        if ($direction === self::DIRECTION_CCW) {
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
            Cube::FACE_FRONT => [
                Cube::FACE_TOP => [
                    'shift' => 'row',
                    'index' => Cube::CUBE_SIZE - 1,
                    'direction' => true,
                    'next' => Cube::FACE_RIGHT
                ],
                Cube::FACE_RIGHT => [
                    'shift' => 'column',
                    'index' => 0,
                    'direction' => true,
                    'next' => Cube::FACE_BOTTOM
                ],
                Cube::FACE_BOTTOM => [
                    'shift' => 'row',
                    'index' => 0,
                    'direction' => false,
                    'next' => Cube::FACE_LEFT
                ],
                Cube::FACE_LEFT => [
                    'shift' => 'column',
                    'index' => Cube::CUBE_SIZE - 1,
                    'direction' => false,
                    'next' => Cube::FACE_TOP
                ],
            ],
            Cube::FACE_BACK => [
                Cube::FACE_TOP => [
                    'shift' => 'row',
                    'index' => 0,
                    'direction' => false,
                    'next' => Cube::FACE_RIGHT
                ],
                Cube::FACE_LEFT => [
                    'shift' => 'column',
                    'index' => Cube::CUBE_SIZE - 1,
                    'direction' => true,
                    'next' => Cube::FACE_TOP
                ],
                Cube::FACE_BOTTOM => [
                    'shift' => 'row',
                    'index' => Cube::CUBE_SIZE - 1,
                    'direction' => true,
                    'next' => Cube::FACE_LEFT
                ],
                Cube::FACE_RIGHT => [
                    'shift' => 'column',
                    'index' => 0,
                    'direction' => false,
                    'next' => Cube::FACE_BOTTOM
                ],
            ],
            Cube::FACE_LEFT => [
                Cube::FACE_TOP => [
                    'shift' => 'column',
                    'index' => 0,
                    'direction' => true,
                    'next' => Cube::FACE_FRONT
                ],
                Cube::FACE_FRONT => [
                    'shift' => 'column',
                    'index' => 0,
                    'direction' => true,
                    'next' => Cube::FACE_BOTTOM
                ],
                Cube::FACE_BOTTOM => [
                    'shift' => 'column',
                    'index' => 0,
                    'direction' => true,
                    'next' => Cube::FACE_BACK
                ],
                Cube::FACE_BACK => [
                    'shift' => 'column',
                    'index' => Cube::CUBE_SIZE - 1,
                    'direction' => false,
                    'next' => Cube::FACE_TOP
                ],
            ],
            Cube::FACE_RIGHT => [
                Cube::FACE_TOP => [
                    'shift' => 'column',
                    'index' => Cube::CUBE_SIZE - 1,
                    'direction' => true,
                    'next' => Cube::FACE_BACK
                ],
                Cube::FACE_BACK => [
                    'shift' => 'column',
                    'index' => 0,
                    'direction' => false,
                    'next' => Cube::FACE_BOTTOM
                ],
                Cube::FACE_BOTTOM => [
                    'shift' => 'column',
                    'index' => Cube::CUBE_SIZE - 1,
                    'direction' => true,
                    'next' => Cube::FACE_FRONT
                ],
                Cube::FACE_FRONT => [
                    'shift' => 'column',
                    'index' => Cube::CUBE_SIZE - 1,
                    'direction' => true,
                    'next' => Cube::FACE_TOP
                ],
            ],
            Cube::FACE_TOP => [
                Cube::FACE_FRONT => [
                    'shift' => 'row',
                    'index' => 0,
                    'direction' => false,
                    'next' => Cube::FACE_LEFT
                ],
                Cube::FACE_LEFT => [
                    'shift' => 'row',
                    'index' => 0,
                    'direction' => false,
                    'next' => Cube::FACE_BACK
                ],
                Cube::FACE_BACK => [
                    'shift' => 'row',
                    'index' => 0,
                    'direction' => false,
                    'next' => Cube::FACE_RIGHT
                ],
                Cube::FACE_RIGHT => [
                    'shift' => 'row',
                    'index' => 0,
                    'direction' => false,
                    'next' => Cube::FACE_FRONT
                ],
            ],
            Cube::FACE_BOTTOM => [
                Cube::FACE_FRONT => [
                    'shift' => 'row',
                    'index' => Cube::CUBE_SIZE - 1,
                    'direction' => true,
                    'next' => Cube::FACE_LEFT
                ],
                Cube::FACE_RIGHT => [
                    'shift' => 'row',
                    'index' => Cube::CUBE_SIZE - 1,
                    'direction' => true,
                    'next' => Cube::FACE_FRONT
                ],
                Cube::FACE_BACK => [
                    'shift' => 'row',
                    'index' => Cube::CUBE_SIZE - 1,
                    'direction' => true,
                    'next' => Cube::FACE_RIGHT
                ],
                Cube::FACE_LEFT => [
                    'shift' => 'row',
                    'index' => Cube::CUBE_SIZE - 1,
                    'direction' => true,
                    'next' => Cube::FACE_BACK
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
