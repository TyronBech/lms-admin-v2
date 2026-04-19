<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('bk_books')) {
            Schema::create('bk_books', function (Blueprint $table): void {
                $table->id();
                $table->string('accession', 20);
                $table->string('call_number', 50)->nullable();
                $table->text('author')->nullable();
                $table->string('title', 150);
                $table->enum('book_type', ['physical', 'ebook'])->default('physical');
                $table->text('description')->nullable();
                $table->string('edition', 50)->nullable();
                $table->string('place_of_publication', 50)->nullable();
                $table->string('publisher', 100)->nullable();
                $table->string('copyrights', 50)->nullable();
                $table->enum('remarks', ['On Shelf', 'Missing', 'Lost', 'Discarded', 'Lost And Paid For'])->default('On Shelf');
                $table->foreignId('category_id')->constrained('bk_categories')->cascadeOnDelete()->cascadeOnUpdate();
                $table->binary('cover_image')->nullable();
                $table->string('digital_copy_url')->nullable();
                $table->binary('barcode')->nullable();
                $table->enum('availability_status', ['Available', 'Unavailable', 'Borrowed', 'In Use', 'Reserved'])->default('Available');
                $table->enum('condition_status', ['New', 'Good', 'Fair', 'Poor'])->default('Good');
                $table->timestamp('created_at')->nullable()->useCurrent();
                $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();
                $table->timestamp('deleted_at')->nullable();

                $table->string('active_accession', 20)->storedAs('CASE WHEN deleted_at IS NULL THEN accession ELSE NULL END');

                $table->unique('active_accession', 'uniq_book_accession');
                $table->index('category_id', 'idx_book_category_id');
            });
        }

        if (DB::getDriverName() === 'mysql' && Schema::hasTable('bk_books')) {
            DB::statement('ALTER TABLE bk_books MODIFY cover_image LONGBLOB NULL');
            DB::statement('ALTER TABLE bk_books MODIFY barcode BLOB NULL');
            DB::statement('ALTER TABLE bk_books ADD FULLTEXT ftx_book_title (title)');
            DB::statement('ALTER TABLE bk_books ADD FULLTEXT ftx_book_author (author)');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('bk_books');
    }
};
