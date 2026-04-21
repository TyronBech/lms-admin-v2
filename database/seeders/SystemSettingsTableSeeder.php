<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class SystemSettingsTableSeeder extends Seeder
{
  /**
   * Seed system_settings table.
   */
  public function run(): void
  {
    $systemSettings = [
      [
        'key' => 'reservation_system_active',
        'value' => 'true',
        'description' => 'Indicates if the reservation system is active.',
      ],
      [
        'key' => 'inventory_cycle_active',
        'value' => '0',
        'description' => 'Tracks whether the book inventory cycle is currently active.',
      ],
    ];

    foreach ($systemSettings as $setting) {
      SystemSetting::query()->updateOrCreate(
        ['key' => $setting['key']],
        [
          'value' => $setting['value'],
          'description' => $setting['description'],
        ],
      );
    }
  }
}
