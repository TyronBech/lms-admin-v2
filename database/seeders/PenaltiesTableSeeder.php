<?php

namespace Database\Seeders;

use App\Models\LibraryUser;
use App\Models\Penalty;
use App\Models\PenaltyRule;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenaltiesTableSeeder extends Seeder
{
  /**
   * Seed tr_penalties table.
   */
  public function run(): void
  {
    DB::beginTransaction();

    try {
      DB::statement('SET @current_user_id = ?', [$this->resolveActorId()]);

      $overdueTransactions = Transaction::query()
        ->where('status', 'Overdue')
        ->get();

      $rules = PenaltyRule::query()->get();

      foreach ($overdueTransactions as $transaction) {
        if ($transaction->penalties()->exists()) {
          continue;
        }

        $rule = $rules->isNotEmpty() ? $rules->random() : PenaltyRule::factory()->create();

        Penalty::query()->create([
          'transaction_id' => $transaction->id,
          'penalty_rule_id' => $rule->id,
          'amount' => $transaction->penalty_total > 0
            ? $transaction->penalty_total
            : fake()->randomFloat(2, 10, 250),
        ]);
      }

      Penalty::query()->with(['transaction', 'penaltyRule'])->get();

      DB::commit();
    } catch (\Throwable $e) {
      DB::rollBack();
      throw $e;
    }
  }

  /**
   * Resolve audit actor id from seeded superadmin.
   */
  private function resolveActorId(): int
  {
    return (int) (LibraryUser::query()
      ->where('email', 'tyronbechayda1112@gmail.com')
      ->value('id') ?? 0);
  }
}
