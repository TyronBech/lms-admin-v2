<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\LibraryUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventoriesTableSeeder extends Seeder
{
  /**
   * Seed bk_inventories table.
   */
  public function run(): void
  {
    DB::beginTransaction();

    try {
      DB::statement('SET @current_user_id = ?', [$this->resolveActorId()]);

      $books = Book::query()->with(['category'])->get();

      foreach ($books->take(90) as $book) {
        if (! $book->inventories()->exists()) {
          $book->inventories()->create([
            'is_scanned' => fake()->boolean(70),
            'checked_at' => fake()->optional(80)->dateTimeBetween('-20 days', 'now'),
          ]);
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
