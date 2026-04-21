<?php

namespace Database\Factories;

use App\Models\EmployeeDetail;
use App\Models\LibraryUser;
use App\Models\Privilege;
use App\Models\StudentDetail;
use App\Models\VisitorDetail;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<LibraryUser>
 */
class LibraryUserFactory extends Factory
{
  /**
   * @var class-string<LibraryUser>
   */
  protected $model = LibraryUser::class;

  /**
   * @var string|null
   */
  protected static ?string $password = null;

  /**
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'rfid' => sprintf('RF%08d', fake()->unique()->numberBetween(1, 99999999)),
      'privilege_id' => fn(): int => Privilege::query()->inRandomOrder()->value('id')
        ?? Privilege::factory()->create()->id,
      'first_name' => fake()->firstName(),
      'middle_name' => fake()->boolean(35) ? fake()->lastName() : null,
      'last_name' => fake()->lastName(),
      'suffix' => fake()->boolean(15) ? fake()->randomElement(['Jr.', 'Sr.', 'III']) : null,
      'gender' => fake()->randomElement(['Male', 'Female']),
      'profile_image' => null,
      'email' => Str::lower(substr((string) fake()->unique()->safeEmail(), 0, 50)),
      'email_verified_at' => now(),
      'password' => static::$password ??= Hash::make('password'),
      'two_factor_enabled' => false,
      'two_factor_secret' => null,
      'two_factor_backup_codes' => null,
      'remember_token' => Str::random(10),
    ];
  }

  /**
   * Ensure exactly one detail record is created based on privilege user_type.
   */
  public function configure(): static
  {
    return $this->afterCreating(function (LibraryUser $user): void {
      $userType = Str::lower((string) optional($user->privilege)->user_type);

      if ($userType === 'student' && ! $user->studentDetail()->exists()) {
        StudentDetail::factory()->for($user, 'user')->create();
      }

      if ($userType === 'employee' && ! $user->employeeDetail()->exists()) {
        EmployeeDetail::factory()->for($user, 'user')->create();
      }

      if ($userType === 'visitor' && ! $user->visitorDetail()->exists()) {
        VisitorDetail::factory()->for($user, 'user')->create();
      }
    });
  }

  /**
   * Skip automatic detail record creation after the user is persisted.
   *
   * Use this state when calling LibraryUserFactory from within a detail factory
   * (StudentDetailFactory, EmployeeDetailFactory, VisitorDetailFactory) to prevent
   * a duplicate detail row from being created by the afterCreating hook.
   */
  public function withoutAutoDetails(): static
  {
    return $this->withoutAfterCreating();
  }

  /**
   * Generate a user under a student privilege.
   */
  public function student(): static
  {
    return $this->state(fn(): array => [
      'privilege_id' => $this->resolvePrivilegeId('student'),
    ]);
  }

  /**
   * Generate a user under an employee privilege.
   */
  public function employee(): static
  {
    return $this->state(fn(): array => [
      'privilege_id' => $this->resolvePrivilegeId('employee'),
    ]);
  }

  /**
   * Generate a user under a visitor privilege.
   */
  public function visitor(): static
  {
    return $this->state(fn(): array => [
      'privilege_id' => $this->resolvePrivilegeId('visitor'),
    ]);
  }

  /**
   * Resolve or create a privilege for a target user type.
   */
  private function resolvePrivilegeId(string $userType): int
  {
    $existing = Privilege::query()
      ->whereRaw('LOWER(user_type) = ?', [Str::lower($userType)])
      ->inRandomOrder()
      ->value('id');

    if (is_int($existing)) {
      return $existing;
    }

    return Privilege::factory()->create([
      'user_type' => $userType,
      'category' => Str::ucfirst($userType),
      'duration_type' => $userType === 'visitor' ? 'none' : 'standard',
      'max_book_allowed' => $userType === 'visitor' ? 1 : 5,
      'renewal_limit' => $userType === 'visitor' ? 0 : 2,
    ])->id;
  }
}
