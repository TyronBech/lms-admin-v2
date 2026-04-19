<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Represents student-specific user details.
 */
class StudentDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'usr_student_details';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'id_number',
        'level',
        'section',
    ];

    /**
     * Get the owning user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(LibraryUser::class, 'user_id');
    }
}
