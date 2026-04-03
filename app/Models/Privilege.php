<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Represents a privilege policy for users.
 */
class Privilege extends Model
{
  use HasFactory;
  use SoftDeletes;

  /**
   * @var string
   */
  protected $table = 'privileges';

  /**
   * @var array<int, string>
   */
  protected $fillable = [
    'user_type',
    'category',
    'max_book_allowed',
    'duration_type',
    'renewal_limit',
  ];

  /**
   * Get users with this privilege.
   */
  public function users(): HasMany
  {
    return $this->hasMany(LibraryUser::class, 'privilege_id');
  }
}
