<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('log_errors')) {
            Schema::create('log_errors', function (Blueprint $table): void {
                $table->id();
                $table->text('error_message')->nullable();
                $table->dateTime('error_time')->nullable()->useCurrent();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('log_errors');
    }
};
