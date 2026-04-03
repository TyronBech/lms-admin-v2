<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Represents a library book category.
 */
class Category extends Model
{
  use HasFactory;
  use SoftDeletes;

  /**
   * @var string
   */
  protected $table = 'bk_categories';

  /**
   * @var array<int, string>
   */
  protected $fillable = [
    'legend',
    'name',
    'previous_inventory',
    'newly_acquired',
    'discarded',
    'present_inventory',
    'borrow_duration_days',
  ];

  /**
   * Get books under this category.
   */
  public function books(): HasMany
  {
    return $this->hasMany(Book::class, 'category_id');
  }
}
