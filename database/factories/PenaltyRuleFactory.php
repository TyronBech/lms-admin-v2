<?php

namespace Database\Factories;

use App\Models\PenaltyRule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PenaltyRule>
 */
class PenaltyRuleFactory extends Factory
{
    /**
     * @var class-string<PenaltyRule>
     */
    protected $model = PenaltyRule::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['Late Return', 'Lost Book', 'Damaged Book']);

        return [
            'type' => $type,
            'description' => $type . ' penalty',
            'rate' => fake()->randomFloat(2, 5, 200),
            'per_day' => $type === 'Late Return',
        ];
    }
}
