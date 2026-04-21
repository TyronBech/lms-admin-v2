<?php

namespace Database\Factories;

use App\Models\EmployeeDetail;
use App\Models\LibraryUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EmployeeDetail>
 */
class EmployeeDetailFactory extends Factory
{
  /**
   * @var class-string<EmployeeDetail>
   */
  protected $model = EmployeeDetail::class;

  /**
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'user_id' => LibraryUser::factory()->employee()->withoutAutoDetails(),
      'employee_id' => sprintf('EMP%06d', fake()->unique()->numberBetween(1, 999999)),
      'employee_role' => fake()->randomElement(['Teacher', 'Librarian', 'Coordinator', 'Office Staff']),
    ];
  }
}
