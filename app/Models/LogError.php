<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Represents an application error row from log_errors.
 */
class LogError extends Model
{
  use HasFactory;

  /**
   * @var string
   */
  protected $table = 'log_errors';

  /**
   * @var bool
   */
  public $timestamps = false;

  /**
   * @var array<int, string>
   */
  protected $fillable = [
    'error_message',
    'error_time',
  ];

  /**
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'error_time' => 'datetime',
    ];
  }
}
