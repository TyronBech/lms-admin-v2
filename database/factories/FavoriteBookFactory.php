<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\FavoriteBook;
use App\Models\LibraryUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FavoriteBook>
 */
class FavoriteBookFactory extends Factory
{
    /**
     * @var class-string<FavoriteBook>
     */
    protected $model = FavoriteBook::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => LibraryUser::factory()->student(),
            'book_id' => Book::factory(),
        ];
    }
}
