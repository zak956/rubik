<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string[][][]$state
 */
class Cube extends Model
{
    use HasFactory;

    public const CUBE_SIZE = 3;

    /**
     * @var string[]
     */
    protected $casts = [
        'state' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
