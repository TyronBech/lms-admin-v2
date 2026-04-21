<?php

namespace Database\Factories;

use App\Models\Penalty;
use App\Models\PenaltyRule;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Penalty>
 */
class PenaltyFactory extends Factory
{
    /**
     * @var class-string<Penalty>
     */
    protected $model = Penalty::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transaction_id' => Transaction::factory()->overdue(),
            'penalty_rule_id' => PenaltyRule::factory(),
            'amount' => fake()->randomFloat(2, 10, 300),
        ];
    }
}
