<?php

namespace Database\Factories;

use App\Models\LibraryUser;
use App\Models\VisitorDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<VisitorDetail>
 */
class VisitorDetailFactory extends Factory
{
  /**
   * @var class-string<VisitorDetail>
   */
  protected $model = VisitorDetail::class;

  /**
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'user_id' => LibraryUser::factory()->visitor()->withoutAutoDetails(),
      'school_org' => fake()->company(),
      'purpose' => fake()->randomElement(['Research', 'Library Visit', 'Document Request', 'Study']),
    ];
  }
}
