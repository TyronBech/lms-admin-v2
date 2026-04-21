<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Represents a key-value system setting.
 */
class SystemSetting extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'system_settings';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'key',
        'value',
        'description',
    ];
}
