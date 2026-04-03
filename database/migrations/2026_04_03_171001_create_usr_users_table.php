<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::transaction(function (): void {
            if (! Schema::hasTable('usr_users')) {
                Schema::create('usr_users', function (Blueprint $table): void {
                    $table->id();
                    $table->string('rfid', 20)->nullable();
                    $table->foreignId('privilege_id')->nullable()->constrained('privileges')->cascadeOnDelete()->cascadeOnUpdate();
                    $table->string('first_name', 100);
                    $table->string('middle_name', 100)->nullable();
                    $table->string('last_name', 100);
                    $table->string('suffix', 10)->nullable();
                    $table->enum('gender', ['Male', 'Female', 'Prefer not to say']);
                    $table->binary('profile_image')->nullable();
                    $table->string('email', 50)->nullable();
                    $table->timestamp('email_verified_at')->nullable();
                    $table->string('password')->default('123');
                    $table->boolean('two_factor_enabled')->default(false);
                    $table->string('two_factor_secret')->nullable();
                    $table->text('two_factor_backup_codes')->nullable();
                    $table->string('remember_token', 100)->nullable();
                    $table->timestamp('created_at')->nullable()->useCurrent();
                    $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();
                    $table->timestamp('deleted_at')->nullable();

                    $table->unique(['email', 'deleted_at'], 'uniq_users_email');
                    $table->unique(['rfid', 'deleted_at'], 'uniq_users_rfid');
                    $table->index('privilege_id', 'idx_users_privilege_id');
                });
            }

            if (DB::getDriverName() === 'mysql' && Schema::hasTable('usr_users')) {
                DB::statement('ALTER TABLE usr_users MODIFY profile_image LONGBLOB NULL');
            }
        });
    }

    public function down(): void
    {
        DB::transaction(function (): void {
            Schema::dropIfExists('usr_users');
        });
    }
};
