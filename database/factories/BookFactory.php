<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    /**
     * @var class-string<Book>
     */
    protected $model = Book::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $bookType = fake()->randomElement(['physical', 'ebook']);

        return [
            'accession' => sprintf('AC%08d', fake()->unique()->numberBetween(1, 99999999)),
            'isbn' => fake()->optional()->numerify('#############'),
            'call_number' => strtoupper(fake()->bothify('###.## ??#')),
            'author' => fake()->name(),
            'title' => fake()->sentence(4),
            'book_type' => $bookType,
            'description' => fake()->paragraph(),
            'edition' => fake()->optional()->randomElement(['1st', '2nd', '3rd', 'Revised']),
            'place_of_publication' => fake()->city(),
            'publisher' => fake()->company(),
            'copyrights' => (string) fake()->year(),
            'remarks' => fake()->randomElement(['On Shelf', 'Unreturned', 'Missing', 'Lost', 'Discarded', 'Lost And Paid For', 'Lost And Replaced']),
            'category_id' => Category::factory(),
            'cover_image' => null,
            'digital_copy_url' => $bookType === 'ebook' ? fake()->url() : null,
            'barcode' => null,
            'availability_status' => fake()->randomElement(['Available', 'Unavailable', 'Borrowed', 'In Use', 'Reserved']),
            'condition_status' => fake()->randomElement(['New', 'Good', 'Fair', 'Poor']),
        ];
    }
}
