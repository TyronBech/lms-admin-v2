<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('log_user_logs')) {
            Schema::create('log_user_logs', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('usr_users')->cascadeOnDelete()->cascadeOnUpdate();
                $table->enum('computer_use', ['Yes', 'No'])->default('No');
                $table->dateTime('time_in')->nullable();
                $table->dateTime('time_out')->nullable();
                $table->string('remarks', 45)->nullable();
                $table->timestamp('created_at')->nullable()->useCurrent();
                $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();
                $table->dateTime('deleted_at')->nullable();

                $table->index('user_id', 'idx_user_logs_user_id');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('log_user_logs');
    }
};
