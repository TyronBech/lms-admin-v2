<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('usr_student_details')) {
            Schema::create('usr_student_details', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('user_id')->constrained('usr_users')->cascadeOnDelete()->cascadeOnUpdate();
                $table->string('id_number', 20);
                $table->string('level', 15);
                $table->string('section', 100);
                $table->timestamp('created_at')->nullable()->useCurrent();
                $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();
                $table->dateTime('deleted_at')->nullable();

                $table->string('active_id_number', 20)->storedAs('CASE WHEN deleted_at IS NULL THEN id_number ELSE NULL END');

                $table->unique('active_id_number', 'uniq_student_details_id_number');
                $table->index('user_id', 'idx_student_details_user_id');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('usr_student_details');
    }
};
