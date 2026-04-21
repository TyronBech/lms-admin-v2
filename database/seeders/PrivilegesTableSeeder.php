<?php

namespace Database\Seeders;

use App\Models\Privilege;
use Illuminate\Database\Seeder;

class PrivilegesTableSeeder extends Seeder
{
  /**
   * Seed privileges table.
   */
  public function run(): void
  {
    $privileges = [
      [
        'user_type' => 'student',
        'category' => 'Junior High',
        'max_book_allowed' => 3,
        'duration_type' => 'standard',
        'renewal_limit' => 1,
      ],
      [
        'user_type' => 'student',
        'category' => 'Senior High',
        'max_book_allowed' => 4,
        'duration_type' => 'standard',
        'renewal_limit' => 2,
      ],
      [
        'user_type' => 'employee',
        'category' => 'Faculty',
        'max_book_allowed' => 7,
        'duration_type' => 'unlimited',
        'renewal_limit' => 5,
      ],
      [
        'user_type' => 'employee',
        'category' => 'Admin',
        'max_book_allowed' => 10,
        'duration_type' => 'unlimited',
        'renewal_limit' => 5,
      ],
      [
        'user_type' => 'visitor',
        'category' => 'Guest',
        'max_book_allowed' => 1,
        'duration_type' => 'none',
        'renewal_limit' => 0,
      ],
    ];

    foreach ($privileges as $privilege) {
      Privilege::query()->updateOrCreate(
        [
          'user_type' => $privilege['user_type'],
          'category' => $privilege['category'],
        ],
        [
          'max_book_allowed' => $privilege['max_book_allowed'],
          'duration_type' => $privilege['duration_type'],
          'renewal_limit' => $privilege['renewal_limit'],
        ],
      );
    }
  }
}
