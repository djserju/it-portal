<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = [
        'code',
        'name',
        'credits',
        'prerequisites',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'credits' => 'integer',
        ];
    }
}
