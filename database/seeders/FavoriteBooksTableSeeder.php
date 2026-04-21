<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\FavoriteBook;
use App\Models\LibraryUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavoriteBooksTableSeeder extends Seeder
{
    /**
     * Seed bk_favorite_books table.
     */
    public function run(): void
    {
        DB::beginTransaction();

        try {
            DB::statement('SET @current_user_id = ?', [$this->resolveActorId()]);

            $users = LibraryUser::query()
                ->with(['privilege', 'studentDetail', 'employeeDetail', 'visitorDetail'])
                ->get();

            $bookIds = Book::query()->pluck('id');

            if ($bookIds->isNotEmpty()) {
                foreach ($users as $user) {
                    $favoriteCount = fake()->numberBetween(0, 4);

                    if ($favoriteCount === 0) {
                        continue;
                    }

                    $selectedBookIds = $bookIds
                        ->shuffle()
                        ->take($favoriteCount)
                        ->values();

                    foreach ($selectedBookIds as $bookId) {
                        FavoriteBook::query()->firstOrCreate([
                            'user_id' => $user->id,
                            'book_id' => $bookId,
                        ]);
                    }
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Resolve audit actor id from seeded superadmin.
     */
    private function resolveActorId(): int
    {
        return (int) (LibraryUser::query()
            ->where('email', 'tyronbechayda1112@gmail.com')
            ->value('id') ?? 0);
    }
}
