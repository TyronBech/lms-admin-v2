<?php

namespace Database\Seeders;

use App\Enum\RoleEnum;
use App\Models\EmployeeDetail;
use App\Models\LibraryUser;
use App\Models\Privilege;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class SuperAdminTableSeeder extends Seeder
{
  /**
   * @var string
   */
  private const SUPER_ADMIN_EMAIL = 'tyronbechayda1112@gmail.com';

  /**
   * @var string
   */
  private const SUPER_ADMIN_PASSWORD = 'password';

  /**
   * Seed super admin in usr_users and auth provider model.
   */
  public function run(): void
  {
    DB::beginTransaction();

    try {
      DB::statement('SET @current_user_id = ?', [0]);

      Role::findOrCreate(RoleEnum::SuperAdmin->value, 'web');

      $adminPrivilege = Privilege::query()
        ->whereRaw('LOWER(user_type) = ?', ['employee'])
        ->whereRaw('LOWER(category) = ?', ['admin'])
        ->first();

      if (! $adminPrivilege instanceof Privilege) {
        $adminPrivilege = Privilege::factory()->create([
          'user_type' => 'employee',
          'category' => 'Admin',
          'max_book_allowed' => 10,
          'duration_type' => 'unlimited',
          'renewal_limit' => 5,
        ]);
      }

      $superAdmin = LibraryUser::query()->updateOrCreate(
        ['email' => self::SUPER_ADMIN_EMAIL],
        [
          'rfid' => 'RF00000001',
          'privilege_id' => $adminPrivilege->id,
          'first_name' => 'Tyron',
          'middle_name' => null,
          'last_name' => 'Bechayda',
          'suffix' => null,
          'gender' => 'Male',
          'password' => Hash::make(self::SUPER_ADMIN_PASSWORD),
          'two_factor_enabled' => false,
          'two_factor_secret' => null,
          'two_factor_backup_codes' => null,
          'remember_token' => Str::random(10),
          'email_verified_at' => now(),
        ],
      );

      EmployeeDetail::query()->firstOrCreate(
        ['user_id' => $superAdmin->id],
        [
          'employee_id' => 'EMP000001',
          'employee_role' => 'Super Admin',
        ],
      );

      $superAdmin->syncRoles([RoleEnum::SuperAdmin->value]);

      $this->seedConfiguredAuthModelSuperAdmin();

      DB::commit();
    } catch (\Throwable $e) {
      DB::rollBack();
      throw $e;
    }
  }

  /**
   * Ensure super admin exists for the currently configured auth model.
   */
  private function seedConfiguredAuthModelSuperAdmin(): void
  {
    $modelClass = config('auth.providers.users.model');

    if (! is_string($modelClass) || ! class_exists($modelClass)) {
      return;
    }

    if (! is_subclass_of($modelClass, Model::class)) {
      return;
    }

    if ($modelClass === LibraryUser::class) {
      return;
    }

    if ($modelClass === User::class) {
      /** @var User $authUser */
      $authUser = $modelClass::query()->updateOrCreate(
        ['email' => self::SUPER_ADMIN_EMAIL],
        [
          'name' => 'Tyron Bechayda',
          'password' => Hash::make(self::SUPER_ADMIN_PASSWORD),
          'email_verified_at' => now(),
        ],
      );

      if (method_exists($authUser, 'syncRoles')) {
        $authUser->syncRoles([RoleEnum::SuperAdmin->value]);
      }
    }
  }
}
