<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Represents pending users awaiting distribution.
 */
class StagingUser extends Model
{
  use HasFactory;

  /**
   * @var string
   */
  protected $table = 'usr_staging_users';

  /**
   * @var array<int, string>
   */
  protected $fillable = [
    'rfid',
    'first_name',
    'middle_name',
    'last_name',
    'suffix',
    'gender',
    'email',
    'password',
    'profile_image',
    'user_type',
    'id_number',
    'level',
    'section',
    'employee_id',
    'employee_role',
    'school_org',
    'purpose',
  ];
}
