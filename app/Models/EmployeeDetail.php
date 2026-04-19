<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Represents employee-specific user details.
 */
class EmployeeDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'usr_employee_details';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'employee_id',
        'employee_role',
    ];

    /**
     * Get the owning user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(LibraryUser::class, 'user_id');
    }
}
