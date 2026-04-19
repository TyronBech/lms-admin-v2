<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Represents a computed penalty line item.
 */
class Penalty extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'tr_penalties';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'transaction_id',
        'penalty_rule_id',
        'amount',
    ];

    /**
     * @var array<int, string>
     */
    protected $with = [
        'transaction',
        'penaltyRule',
    ];

    /**
     * Get the parent transaction.
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    /**
     * Get the rule used for this penalty.
     */
    public function penaltyRule(): BelongsTo
    {
        return $this->belongsTo(PenaltyRule::class, 'penalty_rule_id');
    }
}
