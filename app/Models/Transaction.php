<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Represents a borrowing or reservation transaction.
 */
class Transaction extends Model
{
  use HasFactory;
  use SoftDeletes;

  /**
   * @var string
   */
  protected $table = 'tr_transactions';

  /**
   * @var array<int, string>
   */
  protected $fillable = [
    'user_id',
    'book_id',
    'reserved_date',
    'pickup_deadline',
    'date_borrowed',
    'due_date',
    'return_date',
    'transaction_type',
    'status',
    'book_condition',
    'penalty_total',
    'penalty_status',
    'remarks',
    'last_reminder_sent_at',
  ];

  /**
   * @var array<int, string>
   */
  protected $with = [
    'user',
    'book',
  ];

  /**
   * Get the user who owns this transaction.
   */
  public function user(): BelongsTo
  {
    return $this->belongsTo(LibraryUser::class, 'user_id');
  }

  /**
   * Get the book associated with this transaction.
   */
  public function book(): BelongsTo
  {
    return $this->belongsTo(Book::class, 'book_id');
  }

  /**
   * Get penalties attached to this transaction.
   */
  public function penalties(): HasMany
  {
    return $this->hasMany(Penalty::class, 'transaction_id');
  }

  /**
   * Get notifications related to this transaction.
   */
  public function notifications(): HasMany
  {
    return $this->hasMany(Notification::class, 'transaction_id');
  }
}
