<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\LibraryUser;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * @var class-string<Transaction>
     */
    protected $model = Transaction::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dateBorrowed = fake()->dateTimeBetween('-30 days', '-1 day');
        $dueDate = (clone $dateBorrowed)->modify('+7 days');

        return [
            'user_id' => LibraryUser::factory()->student(),
            'book_id' => Book::factory(),
            'reserved_date' => null,
            'pickup_deadline' => null,
            'date_borrowed' => $dateBorrowed,
            'due_date' => $dueDate,
            'return_date' => null,
            'transaction_type' => 'Borrowed',
            'status' => 'Borrowed',
            'book_condition' => fake()->randomElement(['New', 'Good', 'Fair', 'Poor']),
            'penalty_total' => 0,
            'penalty_status' => 'No Penalty',
            'remarks' => null,
            'last_reminder_sent_at' => null,
        ];
    }

    /**
     * Returned/completed transaction state.
     */
    public function returned(): static
    {
        return $this->state(function (): array {
            $dateBorrowed = fake()->dateTimeBetween('-30 days', '-10 days');
            $returnDate = (clone $dateBorrowed)->modify('+' . fake()->numberBetween(2, 12) . ' days');

            return [
                'transaction_type' => 'Returned',
                'status' => 'Completed',
                'date_borrowed' => $dateBorrowed,
                'due_date' => (clone $dateBorrowed)->modify('+7 days'),
                'return_date' => $returnDate,
                'penalty_total' => 0,
                'penalty_status' => 'No Penalty',
                'remarks' => 'Returned in good condition',
            ];
        });
    }

    /**
     * Reserved transaction state.
     */
    public function reserved(): static
    {
        return $this->state(function (): array {
            $reservedDate = fake()->dateTimeBetween('-7 days', 'now');

            return [
                'transaction_type' => 'Reserved',
                'status' => fake()->randomElement(['Pending', 'Available for pick up']),
                'reserved_date' => $reservedDate,
                'pickup_deadline' => (clone $reservedDate)->modify('+2 days'),
                'date_borrowed' => null,
                'due_date' => null,
                'return_date' => null,
                'remarks' => 'Waiting for pickup',
            ];
        });
    }

    /**
     * Overdue transaction state.
     */
    public function overdue(): static
    {
        return $this->state(function (): array {
            $dateBorrowed = fake()->dateTimeBetween('-25 days', '-12 days');
            $dueDate = (clone $dateBorrowed)->modify('+7 days');

            return [
                'transaction_type' => 'Borrowed',
                'status' => 'Overdue',
                'date_borrowed' => $dateBorrowed,
                'due_date' => $dueDate,
                'return_date' => null,
                'penalty_total' => fake()->randomFloat(2, 20, 250),
                'penalty_status' => 'Unpaid',
                'remarks' => 'Overdue item',
                'last_reminder_sent_at' => fake()->dateTimeBetween($dueDate, 'now'),
            ];
        });
    }
}
