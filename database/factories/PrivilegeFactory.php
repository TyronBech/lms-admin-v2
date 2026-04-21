<?php

namespace Database\Factories;

use App\Models\Privilege;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Privilege>
 */
class PrivilegeFactory extends Factory
{
  /**
   * @var class-string<Privilege>
   */
  protected $model = Privilege::class;

  /**
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $userType = fake()->randomElement(['student', 'employee', 'visitor']);

    $category = match ($userType) {
      'student' => fake()->randomElement(['Junior High', 'Senior High', 'College']),
      'employee' => fake()->randomElement(['Faculty', 'Staff', 'Admin']),
      default => fake()->randomElement(['Guest', 'Parent', 'Researcher']),
    };

    $durationType = match ($userType) {
      'visitor' => fake()->randomElement(['none', 'standard']),
      default => fake()->randomElement(['standard', 'unlimited']),
    };

    return [
      'user_type' => $userType,
      'category' => $category,
      'max_book_allowed' => $userType === 'visitor'
        ? fake()->numberBetween(1, 2)
        : fake()->numberBetween(2, 7),
      'duration_type' => $durationType,
      'renewal_limit' => $durationType === 'none' ? 0 : fake()->numberBetween(1, 5),
    ];
  }
}
