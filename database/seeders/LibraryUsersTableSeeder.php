<?php

namespace Database\Seeders;

use App\Models\LibraryUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LibraryUsersTableSeeder extends Seeder
{
  /**
   * Seed usr_users table.
   */
  public function run(): void
  {
    DB::beginTransaction();

    try {
      DB::statement('SET @current_user_id = ?', [$this->resolveActorId()]);

      $targetUsers = 48;
      $existingUsers = LibraryUser::query()->count();

      if ($existingUsers < $targetUsers) {
        $remaining = $targetUsers - $existingUsers;

        $studentCount = (int) floor($remaining * 0.55);
        $employeeCount = (int) floor($remaining * 0.25);
        $visitorCount = $remaining - $studentCount - $employeeCount;

        if ($studentCount > 0) {
          LibraryUser::factory()->count($studentCount)->student()->create();
        }

        if ($employeeCount > 0) {
          LibraryUser::factory()->count($employeeCount)->employee()->create();
        }

        if ($visitorCount > 0) {
          LibraryUser::factory()->count($visitorCount)->visitor()->create();
        }
      }

      LibraryUser::query()
        ->with([
          'privilege',
          'studentDetail',
          'employeeDetail',
          'visitorDetail',
        ])
        ->get();

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
