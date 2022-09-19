<?php

namespace Tests\Unit\Managers;

use App\Enums\Directions;
use App\Enums\Faces;
use App\Models\Cube;
use App\Processors\CubeProcessorInterface;
use App\Managers\CubeManager;
use App\Processors\CubeProcessor;
use App\Repository\CubeRepository;
use App\Repository\CubeRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

/**
 * @runTestsInSeparateProcesses
 */
class CubeManagerTest extends TestCase
{
    /**
     * @return void
     */
    public function testCreate(): void
    {
        $processor = $this->getProcessorMock();
        $processor->expects($this->once())->method('setCubeState');
        $processor->expects($this->once())->method('getCubeState');
        $processor->expects($this->once())->method('init');
        $processor->expects($this->never())->method('shuffle');
        $processor->expects($this->never())->method('rotate');

        $repository = $this->getRepoMock();
        $repository->expects($this->once())->method('createCube');
        $repository->expects($this->once())->method('saveCube');

        $m = new CubeManager($processor, $repository);
        $m->create();
    }

    /**
     * @return void
     */
    public function testInit(): void
    {
        $processor = $this->getProcessorMock();
        $processor->expects($this->once())->method('setCubeState');
        $processor->expects($this->once())->method('getCubeState');
        $processor->expects($this->once())->method('init');
        $processor->expects($this->never())->method('shuffle');
        $processor->expects($this->never())->method('rotate');

        $repository = $this->getRepoMock();
        $repository->expects($this->never())->method('createCube');
        $repository->expects($this->once())->method('saveCube');

        $m = new CubeManager($processor, $repository);
        $m->init(new Cube());
    }

    /**
     * @return void
     */
    public function testShuffle(): void
    {
        $processor = $this->getProcessorMock();
        $processor->expects($this->once())->method('setCubeState');
        $processor->expects($this->once())->method('getCubeState');
        $processor->expects($this->once())->method('shuffle');
        $processor->expects($this->never())->method('init');
        $processor->expects($this->never())->method('rotate');

        $repository = $this->getRepoMock();
        $repository->expects($this->once())->method('saveCube');
        $repository->expects($this->never())->method('createCube');

        $m = new CubeManager($processor, $repository);
        $m->shuffle(new Cube());
    }

    /**
     * @return void
     */
    public function testRotate(): void
    {
        $face = Faces::fromValue(Faces::getRandomValue());
        $direction = Directions::fromValue(Directions::getRandomValue());

        $processor = $this->getProcessorMock();
        $processor->expects($this->once())->method('setCubeState');
        $processor->expects($this->once())->method('getCubeState');
        $processor->expects($this->once())->method('rotate')->with($face, $direction);
        $processor->expects($this->never())->method('init');
        $processor->expects($this->never())->method('shuffle');

        $repository = $this->getRepoMock();
        $repository->expects($this->once())->method('saveCube');
        $repository->expects($this->never())->method('createCube');

        $m = new CubeManager($processor, $repository);
        $m->rotate(new Cube(), $face, $direction);
    }

    /**
     * @return CubeRepositoryInterface&MockObject
     */
    protected function getRepoMock()
    {
        return $this->getMockBuilder(CubeRepository::class)
            ->onlyMethods(['saveCube', 'createCube'])
            ->getMock();
    }

    /**
     * @return CubeProcessorInterface&MockObject
     */
    protected function getProcessorMock()
    {
        return $this->getMockBuilder(CubeProcessor::class)
            ->onlyMethods(['setCubeState', 'getCubeState', 'init', 'shuffle', 'rotate'])
            ->getMock();
    }
}
