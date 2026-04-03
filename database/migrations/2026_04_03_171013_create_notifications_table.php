<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
    {
if (! Schema::hasTable('notifications')) {
        Schema::create('notifications', function (Blueprint $table): void {
          $table->id();
          $table->foreignId('user_id')->constrained('usr_users')->cascadeOnDelete()->cascadeOnUpdate();
          $table->foreignId('transaction_id')->nullable()->constrained('tr_transactions')->nullOnDelete()->cascadeOnUpdate();
          $table->string('title', 100);
          $table->text('message');
          $table->string('type', 50);
          $table->dateTime('notif_date')->nullable()->useCurrent();
          $table->string('status', 20)->nullable()->default('unread');
          $table->timestamp('created_at')->nullable()->useCurrent();
          $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();
          $table->dateTime('deleted_at')->nullable();

          $table->index('user_id', 'idx_notif_user');
          $table->index('transaction_id', 'idx_notif_transaction');
        });
      }
  }

  public function down(): void
    {
Schema::dropIfExists('notifications');
  }
};
