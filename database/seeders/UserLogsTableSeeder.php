<?php

namespace Database\Seeders;

use App\Models\LibraryUser;
use App\Models\UserLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserLogsTableSeeder extends Seeder
{
  /**
   * Seed log_user_logs table.
   */
  public function run(): void
  {
    DB::beginTransaction();

    try {
      DB::statement('SET @current_user_id = ?', [$this->resolveActorId()]);

      $users = LibraryUser::query()
        ->with(['privilege', 'studentDetail', 'employeeDetail', 'visitorDetail'])
        ->get();

      // Pre-compute existing log counts per user to avoid N+1 queries.
      $existingCounts = UserLog::query()
        ->whereIn('user_id', $users->pluck('id'))
        ->selectRaw('user_id, COUNT(*) as log_count')
        ->groupBy('user_id')
        ->pluck('log_count', 'user_id');

      foreach ($users as $user) {
        $logCount = (int) ($existingCounts->get($user->id) ?? 0);

        if ($logCount < 2) {
          UserLog::factory()->count(2 - $logCount)->create([
            'user_id' => $user->id,
          ]);
        }
      }

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
      ->where('email', config('seeder.super_admin_email', 'superadmin@local.test'))
      ->value('id') ?? 0);
  }
}
