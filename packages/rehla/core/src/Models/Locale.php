<?php

namespace Rehla\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Locale extends Model
{
    protected $fillable = [
        'code',
        'direction',
    ];
}
