<?php

namespace Database\Factories;

use App\Models\LibraryUser;
use App\Models\UserLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserLog>
 */
class UserLogFactory extends Factory
{
    /**
     * @var class-string<UserLog>
     */
    protected $model = UserLog::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $timeIn = fake()->dateTimeBetween('-14 days', 'now');
        $hasTimeout = fake()->boolean(70);

        return [
            'user_id' => LibraryUser::factory()->student(),
            'computer_use' => fake()->randomElement(['Yes', 'No']),
            'time_in' => $timeIn,
            'time_out' => $hasTimeout ? fake()->dateTimeBetween($timeIn, 'now') : null,
            'remarks' => $hasTimeout ? 'Time out' : 'Time in',
        ];
    }
}
