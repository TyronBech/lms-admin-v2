<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
  /**
   * @var class-string<Category>
   */
  protected $model = Category::class;

  /**
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'legend' => strtoupper(fake()->bothify('??-##')),
      'name' => 'Category ' . fake()->unique()->numberBetween(100, 9999),
      'previous_inventory' => 0,
      'newly_acquired' => 0,
      'discarded' => 0,
      'present_inventory' => 0,
      'borrow_duration_days' => fake()->numberBetween(3, 14),
    ];
  }
}
