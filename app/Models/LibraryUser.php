<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

/**
 * Represents a user record from usr_users.
 */
class LibraryUser extends Model
{
  use HasFactory;
  use HasRoles;
  use SoftDeletes;

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'usr_users';

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'rfid',
    'privilege_id',
    'first_name',
    'middle_name',
    'last_name',
    'suffix',
    'gender',
    'profile_image',
    'email',
    'email_verified_at',
    'password',
    'two_factor_enabled',
    'two_factor_secret',
    'two_factor_backup_codes',
    'remember_token',
  ];

  /**
   * Always eager load the primary profile relation graph.
   *
   * @var array<int, string>
   */
  protected $with = [
    'privilege',
    'studentDetail',
    'employeeDetail',
    'visitorDetail',
  ];

  /**
   * Get attribute casts.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'two_factor_enabled' => 'boolean',
      'password' => 'hashed',
    ];
  }

  /**
   * Get the privilege assigned to the user.
   */
  public function privilege(): BelongsTo
  {
    return $this->belongsTo(Privilege::class, 'privilege_id');
  }

  /**
   * Get the student details associated with the user.
   */
  public function studentDetail(): HasOne
  {
    return $this->hasOne(StudentDetail::class, 'user_id');
  }

  /**
   * Get the employee details associated with the user.
   */
  public function employeeDetail(): HasOne
  {
    return $this->hasOne(EmployeeDetail::class, 'user_id');
  }

  /**
   * Get the visitor details associated with the user.
   */
  public function visitorDetail(): HasOne
  {
    return $this->hasOne(VisitorDetail::class, 'user_id');
  }

  /**
   * Get favorite pivot rows created by this user.
   */
  public function favoriteBooks(): HasMany
  {
    return $this->hasMany(FavoriteBook::class, 'user_id');
  }

  /**
   * Get books favorited by this user.
   */
  public function favoriteBookItems(): BelongsToMany
  {
    return $this->belongsToMany(Book::class, 'bk_favorite_books', 'user_id', 'book_id')
      ->withTimestamps();
  }

  /**
   * Get transactions created by this user.
   */
  public function transactions(): HasMany
  {
    return $this->hasMany(Transaction::class, 'user_id');
  }

  /**
   * Get notifications belonging to this user.
   */
  public function notifications(): HasMany
  {
    return $this->hasMany(Notification::class, 'user_id');
  }

  /**
   * Get user logs belonging to this user.
   */
  public function userLogs(): HasMany
  {
    return $this->hasMany(UserLog::class, 'user_id');
  }
}
