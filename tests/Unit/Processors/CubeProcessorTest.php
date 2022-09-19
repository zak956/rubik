<?php

namespace Tests\Unit\Processors;

use App\Enums\Faces;
use App\Enums\Directions;
use App\Exceptions\NullCubeStateException;
use App\Processors\CubeProcessor;
use Tests\TestCase;

/**
 * @runTestsInSeparateProcesses
 */
class CubeProcessorTest extends TestCase
{
    /**
     * @param $expected
     * @return void
     * @dataProvider getDataForInit
     */
    public function testInit($expected): void
    {
        $p = new CubeProcessor();
        $p->init();
        self::assertEquals($expected, $p->getCubeState());
    }

    /**
     * @param Faces $face
     * @param Directions $direction
     * @param array $expected
     * @return void
     * @throws NullCubeStateException
     * @dataProvider getDataForRotate
     */
    public function testRotate(Faces $face, Directions $direction, array $expected): void
    {
        $p = new CubeProcessor();
        $p->init();
        $p->rotate($face, $direction);
        self::assertEquals($expected, $p->getCubeState());
    }

    /**
     * @return void
     * @throws NullCubeStateException
     */
    public function testRotateException(): void
    {
        $p = new CubeProcessor();
        $this->expectException(NullCubeStateException::class);
        $p->rotate(
            Faces::fromValue(Faces::getRandomValue()),
            Directions::fromValue(Directions::getRandomValue())
        );
    }

    /**
     * @param $expected
     * @return void
     * @dataProvider getDataForInit
     * @throws NullCubeStateException
     */
    public function testShuffle($expected): void
    {
        $p = new CubeProcessor();
        $p->init();
        $p->shuffle();
        self::assertNotEquals($expected, $p->getCubeState());
    }

    /**
     * @return void
     * @throws NullCubeStateException
     */
    public function testShuffleException(): void
    {
        $p = new CubeProcessor();
        $this->expectException(NullCubeStateException::class);
        $p->shuffle();
    }

    /**
     * @return array[]
     */
    public function getDataForInit(): array
    {
        return [
            [
                $this->getInitialState()
            ]
        ];
    }

    /**
     * @return array[]
     */
    public function getDataForRotate(): array
    {
        return [
            [
                Faces::fromValue(Faces::FACE_FRONT),
                Directions::fromValue(Directions::DIRECTION_CCW),
                [
                    "top" => [
                        [
                            "G",
                            "G",
                            "G"
                        ],
                        [
                            "G",
                            "G",
                            "G"
                        ],
                        [
                            "W",
                            "W",
                            "W"
                        ]
                    ],
                    "back" => [
                        [
                            "R",
                            "R",
                            "R"
                        ],
                        [
                            "R",
                            "R",
                            "R"
                        ],
                        [
                            "R",
                            "R",
                            "R"
                        ]
                    ],
                    "left" => [
                        [
                            "O",
                            "O",
                            "G"
                        ],
                        [
                            "O",
                            "O",
                            "G"
                        ],
                        [
                            "O",
                            "O",
                            "G"
                        ]
                    ],
                    "front" => [
                        [
                            "B",
                            "B",
                            "B"
                        ],
                        [
                            "B",
                            "B",
                            "B"
                        ],
                        [
                            "B",
                            "B",
                            "B"
                        ]
                    ],
                    "right" => [
                        [
                            "Y",
                            "W",
                            "W"
                        ],
                        [
                            "Y",
                            "W",
                            "W"
                        ],
                        [
                            "Y",
                            "W",
                            "W"
                        ]
                    ],
                    "bottom" => [
                        [
                            "O",
                            "O",
                            "O"
                        ],
                        [
                            "Y",
                            "Y",
                            "Y"
                        ],
                        [
                            "Y",
                            "Y",
                            "Y"
                        ]
                    ]
                ]
            ],
            [
                Faces::fromValue(Faces::FACE_FRONT),
                Directions::fromValue(Directions::DIRECTION_CW),
                [
                    "top" => [
                        [
                            "G",
                            "G",
                            "G"
                        ],
                        [
                            "G",
                            "G",
                            "G"
                        ],
                        [
                            "O",
                            "O",
                            "O"
                        ]
                    ],
                    "back" => [
                        [
                            "R",
                            "R",
                            "R"
                        ],
                        [
                            "R",
                            "R",
                            "R"
                        ],
                        [
                            "R",
                            "R",
                            "R"
                        ]
                    ],
                    "left" => [
                        [
                            "O",
                            "O",
                            "Y"
                        ],
                        [
                            "O",
                            "O",
                            "Y"
                        ],
                        [
                            "O",
                            "O",
                            "Y"
                        ]
                    ],
                    "front" => [
                        [
                            "B",
                            "B",
                            "B"
                        ],
                        [
                            "B",
                            "B",
                            "B"
                        ],
                        [
                            "B",
                            "B",
                            "B"
                        ]
                    ],
                    "right" => [
                        [
                            "G",
                            "W",
                            "W"
                        ],
                        [
                            "G",
                            "W",
                            "W"
                        ],
                        [
                            "G",
                            "W",
                            "W"
                        ]
                    ],
                    "bottom" => [
                        [
                            "W",
                            "W",
                            "W"
                        ],
                        [
                            "Y",
                            "Y",
                            "Y"
                        ],
                        [
                            "Y",
                            "Y",
                            "Y"
                        ]
                    ]
                ]
            ],
        ];
    }

    public function getInitialState(): array
    {
        return [
            "front" => [
                [
                    "B",
                    "B",
                    "B"
                ],
                [
                    "B",
                    "B",
                    "B"
                ],
                [
                    "B",
                    "B",
                    "B"
                ]
            ],
            "left" => [
                [
                    "O",
                    "O",
                    "O"
                ],
                [
                    "O",
                    "O",
                    "O"
                ],
                [
                    "O",
                    "O",
                    "O"
                ]
            ],
            "right" => [
                [
                    "W",
                    "W",
                    "W"
                ],
                [
                    "W",
                    "W",
                    "W"
                ],
                [
                    "W",
                    "W",
                    "W"
                ]
            ],
            "back" => [
                [
                    "R",
                    "R",
                    "R"
                ],
                [
                    "R",
                    "R",
                    "R"
                ],
                [
                    "R",
                    "R",
                    "R"
                ]
            ],
            "top" => [
                [
                    "G",
                    "G",
                    "G"
                ],
                [
                    "G",
                    "G",
                    "G"
                ],
                [
                    "G",
                    "G",
                    "G"
                ]
            ],
            "bottom" => [
                [
                    "Y",
                    "Y",
                    "Y"
                ],
                [
                    "Y",
                    "Y",
                    "Y"
                ],
                [
                    "Y",
                    "Y",
                    "Y"
                ]
            ]

        ];
    }
}
