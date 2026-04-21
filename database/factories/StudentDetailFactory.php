<?php

namespace Database\Factories;

use App\Models\LibraryUser;
use App\Models\StudentDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StudentDetail>
 */
class StudentDetailFactory extends Factory
{
  /**
   * @var class-string<StudentDetail>
   */
  protected $model = StudentDetail::class;

  /**
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'user_id' => LibraryUser::factory()->student()->withoutAutoDetails(),
      'id_number' => sprintf('STU%08d', fake()->unique()->numberBetween(1, 99999999)),
      'level' => fake()->randomElement(['Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12']),
      'section' => fake()->randomElement(['Aquinas', 'Augustine', 'Benedict', 'Francis', 'Dominic']),
    ];
  }
}
