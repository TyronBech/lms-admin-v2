<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Represents a user notification.
 */
class Notification extends Model
{
  use HasFactory;
  use SoftDeletes;

  /**
   * @var string
   */
  protected $table = 'notifications';

  /**
   * @var array<int, string>
   */
  protected $fillable = [
    'user_id',
    'transaction_id',
    'title',
    'message',
    'type',
    'notif_date',
    'status',
  ];

  /**
   * @var array<int, string>
   */
  protected $with = [
    'user',
    'transaction',
  ];

  /**
   * Get the user owning this notification.
   */
  public function user(): BelongsTo
  {
    return $this->belongsTo(LibraryUser::class, 'user_id');
  }

  /**
   * Get the related transaction.
   */
  public function transaction(): BelongsTo
  {
    return $this->belongsTo(Transaction::class, 'transaction_id');
  }
}
