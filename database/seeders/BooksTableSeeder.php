<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\LibraryUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BooksTableSeeder extends Seeder
{
  /**
   * Seed bk_books table.
   */
  public function run(): void
  {
    DB::beginTransaction();

    try {
      DB::statement('SET @current_user_id = ?', [$this->resolveActorId()]);

      $targetBooks = 140;
      $existingBooks = Book::query()->count();
      $categories = Category::query()->get();

      if ($existingBooks < $targetBooks && $categories->isNotEmpty()) {
        $toCreate = $targetBooks - $existingBooks;

        for ($index = 0; $index < $toCreate; $index++) {
          Book::factory()->create([
            'category_id' => $categories->random()->id,
          ]);
        }
      }

      Book::query()->with(['category'])->get();

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
      ->where('email', config('seeder.super_admin_email', 'superadmin@local.test'))
      ->value('id') ?? 0);
  }
}
