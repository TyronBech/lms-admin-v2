<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Inventory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Inventory>
 */
class InventoryFactory extends Factory
{
    /**
     * @var class-string<Inventory>
     */
    protected $model = Inventory::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $checkedAt = fake()->optional(80)->dateTimeBetween('-20 days', 'now');

        return [
            'book_id' => Book::factory(),
            'is_scanned' => $checkedAt !== null,
            'checked_at' => $checkedAt,
        ];
    }
}
