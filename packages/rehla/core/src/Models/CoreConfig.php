<?php

namespace Rehla\Core\Models;

use Illuminate\Database\Eloquent\Model;

class CoreConfig extends Model
{
    protected $table = 'core_config';

    protected $fillable = [
        'key',
        'value',
        'locale_code',
        'is_secret',
    ];

    protected $casts = [
        'is_secret' => 'boolean',
    ];

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $array = parent::toArray();

        if ($this->is_secret) {
            unset($array['value']);
        }

        return $array;
    }
}
