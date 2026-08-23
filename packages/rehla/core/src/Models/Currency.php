<?php

namespace Rehla\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        'code',
        'precision',
    ];

    protected $casts = [
        'precision' => 'integer',
    ];
}
