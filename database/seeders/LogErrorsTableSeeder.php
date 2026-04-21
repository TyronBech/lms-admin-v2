<?php

namespace Database\Seeders;

use App\Models\LogError;
use Illuminate\Database\Seeder;

class LogErrorsTableSeeder extends Seeder
{
  /**
   * Seed log_errors table.
   */
  public function run(): void
  {
    if (LogError::query()->count() < 10) {
      LogError::factory()->count(10 - LogError::query()->count())->create();
    }
  }
}
