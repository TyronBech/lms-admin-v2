<?php

namespace Database\Seeders;

use App\Models\UiSetting;
use Illuminate\Database\Seeder;

class UiSettingsTableSeeder extends Seeder
{
  /**
   * Seed ui_settings table.
   */
  public function run(): void
  {
    if (! UiSetting::query()->exists()) {
      UiSetting::factory()->create();
    }
  }
}
