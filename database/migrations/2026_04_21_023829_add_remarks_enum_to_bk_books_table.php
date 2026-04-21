<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bk_books', function (Blueprint $table) {
            $table->enum('remarks', ['On Shelf', 'Unreturned', 'Missing', 'Lost', 'Discarded', 'Lost And Paid For', 'Lost And Replaced'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bk_books', function (Blueprint $table) {
            $table->enum('remarks', ['On Shelf', 'Missing', 'Lost', 'Discarded', 'Lost And Paid For'])->change();
        });
    }
};
