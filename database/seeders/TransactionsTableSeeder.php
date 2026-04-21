<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\LibraryUser;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionsTableSeeder extends Seeder
{
  /**
   * Seed tr_transactions table.
   */
  public function run(): void
  {
    DB::beginTransaction();

    try {
      DB::statement('SET @current_user_id = ?', [$this->resolveActorId()]);

      $targetTransactions = 180;
      $existingTransactions = Transaction::query()->count();

      if ($existingTransactions < $targetTransactions) {
        $users = LibraryUser::query()
          ->with([
            'privilege',
            'studentDetail',
            'employeeDetail',
            'visitorDetail',
          ])
          ->whereHas('privilege', function ($query): void {
            $query->whereIn('user_type', ['student', 'employee']);
          })
          ->get();

        $books = Book::query()->with(['category'])->get();

        if ($users->isNotEmpty() && $books->isNotEmpty()) {
          $remaining = $targetTransactions - $existingTransactions;

          for ($index = 0; $index < $remaining; $index++) {
            $user = $users->random();
            $book = $books->random();

            $variant = fake()->randomElement(['borrowed', 'returned', 'reserved', 'overdue']);

            $factory = Transaction::factory();
            if ($variant === 'returned') {
              $factory = $factory->returned();
            }
            if ($variant === 'reserved') {
              $factory = $factory->reserved();
            }
            if ($variant === 'overdue') {
              $factory = $factory->overdue();
            }

            $factory->create([
              'user_id' => $user->id,
              'book_id' => $book->id,
            ]);
          }
        }
      }

      Transaction::query()->with(['user', 'book'])->get();

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
