<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Represents a penalty rule configuration.
 */
class PenaltyRule extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'penalty_rules';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'description',
        'rate',
        'per_day',
    ];

    /**
     * Get penalties generated from this rule.
     */
    public function penalties(): HasMany
    {
        return $this->hasMany(Penalty::class, 'penalty_rule_id');
    }
}
