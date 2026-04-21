<?php

namespace Database\Seeders;

use App\Models\StagingUser;
use Illuminate\Database\Seeder;

class StagingUsersTableSeeder extends Seeder
{
  /**
   * Seed usr_staging_users table.
   */
  public function run(): void
  {
    $existing = StagingUser::query()->count();

    if ($existing < 15) {
      StagingUser::factory()->count(15 - $existing)->create();
    }
  }
}
