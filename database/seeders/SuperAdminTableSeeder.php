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
   * Seed super admin in usr_users and auth provider model.
   */
  public function run(): void
  {
    if (! app()->environment('local', 'development', 'staging')) {
      $this->command->warn('[SuperAdminTableSeeder] Skipped: not a local/dev/staging environment.');

      return;
    }

    $email = (string) config('seeder.super_admin_email', 'superadmin@local.test');
    $rawPassword = (string) config('seeder.super_admin_password', Str::random(16));

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
        ['email' => $email],
        [
          'rfid' => 'RF00000001',
          'privilege_id' => $adminPrivilege->id,
          'first_name' => 'Super',
          'middle_name' => null,
          'last_name' => 'Admin',
          'suffix' => null,
          'gender' => 'Male',
          'password' => Hash::make($rawPassword),
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

      $this->seedConfiguredAuthModelSuperAdmin($email, $rawPassword);

      DB::commit();

      $this->command->info("[SuperAdminTableSeeder] Super admin seeded. Email: {$email}");
    } catch (\Throwable $e) {
      DB::rollBack();
      throw $e;
    }
  }

  /**
   * Ensure super admin exists for the currently configured auth model.
   */
  private function seedConfiguredAuthModelSuperAdmin(string $email, string $rawPassword): void
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
        ['email' => $email],
        [
          'name' => 'Super Admin',
          'password' => Hash::make($rawPassword),
          'email_verified_at' => now(),
        ],
      );

      if (method_exists($authUser, 'syncRoles')) {
        $authUser->syncRoles([RoleEnum::SuperAdmin->value]);
      }
    }
  }
}
