<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Represents user library usage logs.
 */
class UserLog extends Model
{
  use HasFactory;
  use SoftDeletes;

  /**
   * @var string
   */
  protected $table = 'log_user_logs';

  /**
   * @var array<int, string>
   */
  protected $fillable = [
    'user_id',
    'computer_use',
    'time_in',
    'time_out',
    'remarks',
  ];

  /**
   * Get the user for this log row.
   */
  public function user(): BelongsTo
  {
    return $this->belongsTo(LibraryUser::class, 'user_id');
  }
}
