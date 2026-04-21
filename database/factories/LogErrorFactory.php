<?php

namespace Database\Factories;

use App\Models\LogError;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LogError>
 */
class LogErrorFactory extends Factory
{
    /**
     * @var class-string<LogError>
     */
    protected $model = LogError::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'error_message' => fake()->sentence(10),
            'error_time' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
