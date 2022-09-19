<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static FACE_TOP()
 * @method static static FACE_FRONT()
 * @method static static FACE_LEFT()
 * @method static static FACE_RIGHT()
 * @method static static FACE_BOTTOM()
 * @method static static FACE_BACK()
 */
class Faces extends Enum
{
    public const FACE_TOP = 'top';
    public const FACE_FRONT = 'front';
    public const FACE_LEFT = 'left';
    public const FACE_RIGHT = 'right';
    public const FACE_BOTTOM = 'bottom';
    public const FACE_BACK = 'back';
}
