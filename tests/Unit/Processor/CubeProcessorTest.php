<?php

namespace Tests\Unit\Processor;

use App\Exceptions\NullCubeStateException;
use App\Models\Cube;
use App\Processor\CubeProcessor;
use Tests\TestCase;

class CubeProcessorTest extends TestCase
{
    /**
     * @param $expected
     * @return void
     * @dataProvider getDataForInit
     */
    public function testInit($expected): void
    {
        $p = new CubeProcessor(null);
        $p->init();
        self::assertEquals($expected, $p->getCubeState());
    }

    /**
     * @param $face
     * @param $direction
     * @param $expected
     * @return void
     * @dataProvider getDataForRotate
     * @throws NullCubeStateException
     */
    public function testRotate($face, $direction, $expected): void
    {
        $p = new CubeProcessor(null);
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
        $p = new CubeProcessor(null);
        $this->expectException(NullCubeStateException::class);
        $p->rotate('ololo', 'ololo');
    }

    /**
     * @param $expected
     * @return void
     * @dataProvider getDataForInit
     * @throws NullCubeStateException
     */
    public function testShuffle($expected): void
    {
        $p = new CubeProcessor(null);
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
        $p = new CubeProcessor(null);
        $this->expectException(NullCubeStateException::class);
        $p->shuffle();
    }

    public function getDataForInit(): array
    {
        return [
            [
                $this->getInitialState()
            ]
        ];
    }

    public function getDataForRotate(): array
    {
        return [
            [
                Cube::FACE_FRONT,
                CubeProcessor::DIRECTION_CCW,
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
                Cube::FACE_FRONT,
                CubeProcessor::DIRECTION_CW,
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
