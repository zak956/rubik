<?php

namespace Tests\Feature;

use App\Enums\Directions;
use App\Enums\Faces;
use App\Processors\CubeProcessor;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

/**
 * @runTestsInSeparateProcesses
 */
class CubeTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $response = $this->post('api/cube/create');
        $response->assertStatus(201);
        $expectedData = [
            'data' => [
                'id' => 1,
                'state' => CubeProcessor::getDefaultState()
            ]
        ];
        $response->assertExactJson($expectedData);
    }

    /**
     * @param int $id
     * @param int $expected
     * @return void
     * @dataProvider getData
     */
    public function testGet(int $id, int $expected): void
    {
        $this->seed();
        $response = $this->get('/api/cube/' . $id);
        $response->assertStatus($expected);
        if (200 === $expected) {
            $expectedData = [
                'data' => [
                    'id' => $id,
                    'state' => CubeProcessor::getDefaultState()
                ]
            ];
            $response->assertExactJson($expectedData);
        }
    }

    /**
     * @param int $id
     * @param int $expected
     * @return void
     * @dataProvider getData
     */
    public function testShuffle(int $id, int $expected): void
    {
        $this->seed();
        $response = $this->get(sprintf('/api/cube/%d/shuffle', $id));
        $response->assertStatus($expected);
        if (200 === $expected) {
            $expectedData = [
                'data' => [
                    'id' => $id,
                    'state' => CubeProcessor::getDefaultState()
                ]
            ];
            $response->assertJsonMissingExact($expectedData);
        }
    }

    /**
     * @param int $id
     * @param int $expected
     * @return void
     * @dataProvider getData
     */
    public function testInit(int $id, int $expected): void
    {
        $this->seed();
        $this->get(sprintf('/api/cube/%d/shuffle', $id));
        $response = $this->get(sprintf('/api/cube/%d/init', $id));
        $response->assertStatus($expected);
        if (200 === $expected) {
            $expectedData = [
                'data' => [
                    'id' => $id,
                    'state' => CubeProcessor::getDefaultState()
                ]
            ];
            $response->assertExactJson($expectedData);
        }
    }


    /**
     * @return void
     * @dataProvider getDataForRotate
     */
    public function testRotate(Faces $face, Directions $direction, $expected)
    {
        $this->seed();
        $response = $this->get(sprintf('/api/cube/1/rotate/%s/%s', $face->value, $direction->value));
        $response->assertStatus(200);
        $expectedData = [
            'data' => [
                'id' => 1,
                'state' => $expected
            ]
        ];
        $response->assertExactJson($expectedData);
    }

    public function getData(): array
    {
        return [
            [1, 200],
            [2, 404]
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
