<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Represents visitor-specific user details.
 */
class VisitorDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'usr_visitor_details';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'school_org',
        'purpose',
    ];

    /**
     * Get the owning user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(LibraryUser::class, 'user_id');
    }
}
