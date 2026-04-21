<?php

namespace Database\Seeders;

use App\Models\PenaltyRule;
use Illuminate\Database\Seeder;

class PenaltyRulesTableSeeder extends Seeder
{
  /**
   * Seed penalty_rules table.
   */
  public function run(): void
  {
    $rules = [
      [
        'type' => 'Late Return',
        'description' => 'Penalty for overdue books per day.',
        'rate' => 10,
        'per_day' => true,
      ],
      [
        'type' => 'Lost Book',
        'description' => 'Penalty for books declared lost.',
        'rate' => 250,
        'per_day' => false,
      ],
      [
        'type' => 'Damaged Book',
        'description' => 'Penalty for damaged library materials.',
        'rate' => 120,
        'per_day' => false,
      ],
    ];

    foreach ($rules as $rule) {
      PenaltyRule::query()->updateOrCreate(
        ['type' => $rule['type']],
        [
          'description' => $rule['description'],
          'rate' => $rule['rate'],
          'per_day' => $rule['per_day'],
        ],
      );
    }
  }
}
