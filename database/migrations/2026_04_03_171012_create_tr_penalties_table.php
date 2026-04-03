<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
if (! Schema::hasTable('tr_penalties')) {
                Schema::create('tr_penalties', function (Blueprint $table): void {
                    $table->id();
                    $table->foreignId('transaction_id')->constrained('tr_transactions')->cascadeOnDelete()->cascadeOnUpdate();
                    $table->foreignId('penalty_rule_id')->constrained('penalty_rules')->cascadeOnDelete()->cascadeOnUpdate();
                    $table->decimal('amount', 10, 2);
                    $table->timestamp('created_at')->nullable()->useCurrent();
                    $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();
                    $table->dateTime('deleted_at')->nullable();

                    $table->index('transaction_id', 'fk_transaction_id');
                    $table->index('penalty_rule_id', 'fk_penalty_rule_id');
                });
            }
    }

    public function down(): void
    {
Schema::dropIfExists('tr_penalties');
    }
};
