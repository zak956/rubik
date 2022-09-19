<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static DIRECTION_CCW()
 * @method static static DIRECTION_CW()
 */
class Directions extends Enum
{
    public const DIRECTION_CCW = 'ccw';
    public const DIRECTION_CW = 'cw';
}
