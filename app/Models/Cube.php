<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string[][][]$state
 */
class Cube extends Model
{
    use HasTimestamps;

    public const CUBE_SIZE = 3;

    public const COLOR_RED = 'R';
    public const COLOR_WHITE = 'W';
    public const COLOR_BLUE = 'B';
    public const COLOR_YELLOW = 'Y';
    public const COLOR_GREEN = 'G';
    public const COLOR_ORANGE = 'O';

    public const FACE_FRONT = 'front';
    public const FACE_LEFT = 'left';
    public const FACE_RIGHT = 'right';
    public const FACE_BACK = 'back';
    public const FACE_TOP = 'top';
    public const FACE_BOTTOM = 'bottom';

    public const FACES = [
        self::FACE_FRONT,
        self::FACE_LEFT,
        self::FACE_RIGHT,
        self::FACE_BACK,
        self::FACE_TOP,
        self::FACE_BOTTOM,
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'state' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
