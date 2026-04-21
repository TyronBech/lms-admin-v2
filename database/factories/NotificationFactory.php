<?php

namespace Database\Factories;

use App\Models\LibraryUser;
use App\Models\Notification;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * @var class-string<Notification>
     */
    protected $model = Notification::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => LibraryUser::factory()->student(),
            'transaction_id' => fake()->boolean(70) ? Transaction::factory() : null,
            'title' => fake()->randomElement(['Due Date Reminder', 'Reservation Ready', 'Penalty Notice']),
            'message' => fake()->sentence(12),
            'type' => fake()->randomElement(['info', 'warning', 'alert']),
            'notif_date' => fake()->dateTimeBetween('-30 days', 'now'),
            'status' => fake()->randomElement(['unread', 'read']),
        ];
    }
}
