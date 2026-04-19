<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('tr_transactions')) {
            Schema::create('tr_transactions', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('user_id')->constrained('usr_users')->cascadeOnDelete()->cascadeOnUpdate();
                $table->foreignId('book_id')->constrained('bk_books')->cascadeOnDelete()->cascadeOnUpdate();
                $table->date('reserved_date')->nullable();
                $table->date('pickup_deadline')->nullable();
                $table->date('date_borrowed')->nullable();
                $table->date('due_date')->nullable();
                $table->date('return_date')->nullable();
                $table->enum('transaction_type', ['Borrowed', 'Returned', 'Reserved'])->nullable();
                $table->enum('status', ['Borrowed', 'Pending', 'Available for pick up', 'Completed', 'Overdue', 'Cancelled', 'Lost', 'Missing', 'Renew'])->default('Pending');
                $table->string('book_condition', 20)->nullable()->default('Good');
                $table->decimal('penalty_total', 10, 2)->nullable()->default(0);
                $table->enum('penalty_status', ['No Penalty', 'Paid', 'Unpaid', 'Waived'])->nullable()->default('No Penalty');
                $table->text('remarks')->nullable();
                $table->timestamp('last_reminder_sent_at')->nullable();
                $table->timestamp('created_at')->nullable()->useCurrent();
                $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();
                $table->dateTime('deleted_at')->nullable();

                $table->index('user_id', 'idx_transaction_user_id');
                $table->index(['user_id', 'book_id'], 'idx_transaction_user_id_book_id');
                $table->index('book_id', 'tr_transactions_ibfk_2_idx');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tr_transactions');
    }
};
