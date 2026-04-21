<?php

namespace Database\Seeders;

use App\Models\LibraryUser;
use App\Models\Notification;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationsTableSeeder extends Seeder
{
  /**
   * Seed notifications table.
   */
  public function run(): void
  {
    DB::beginTransaction();

    try {
      DB::statement('SET @current_user_id = ?', [$this->resolveActorId()]);

      $transactions = Transaction::query()->with(['book', 'user'])->get();

      foreach ($transactions as $transaction) {
        $bookTitle = (string) optional($transaction->book)->title;

        Notification::query()->firstOrCreate(
          [
            'user_id' => $transaction->user_id,
            'transaction_id' => $transaction->id,
            'title' => $this->notificationTitle((string) $transaction->status),
          ],
          [
            'message' => $this->notificationMessage((string) $transaction->status, $bookTitle),
            'type' => $transaction->status === 'Overdue' ? 'warning' : 'info',
            'status' => fake()->randomElement(['unread', 'read']),
            'notif_date' => now(),
          ],
        );
      }

      Notification::query()->with(['user', 'transaction'])->get();

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

  /**
   * Get notification title for transaction status.
   */
  private function notificationTitle(string $status): string
  {
    return match ($status) {
      'Overdue' => 'Overdue Notice',
      'Pending', 'Available for pick up' => 'Reservation Update',
      'Completed' => 'Return Confirmation',
      default => 'Transaction Update',
    };
  }

  /**
   * Get notification message for transaction status.
   */
  private function notificationMessage(string $status, string $bookTitle): string
  {
    return match ($status) {
      'Overdue' => 'Your borrowed book "' . $bookTitle . '" is overdue.',
      'Pending' => 'Your reservation for "' . $bookTitle . '" is pending approval.',
      'Available for pick up' => 'Your reserved book "' . $bookTitle . '" is ready for pickup.',
      'Completed' => 'Your return for "' . $bookTitle . '" has been recorded.',
      default => 'Transaction status updated for "' . $bookTitle . '".',
    };
  }
}
