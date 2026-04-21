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

      foreach ($users as $user) {
        $logCount = UserLog::query()->where('user_id', $user->id)->count();

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
      ->where('email', 'tyronbechayda1112@gmail.com')
      ->value('id') ?? 0);
  }
}
