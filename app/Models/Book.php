<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Represents a library book record.
 */
class Book extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'bk_books';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'accession',
        'isbn',
        'call_number',
        'author',
        'title',
        'book_type',
        'description',
        'edition',
        'place_of_publication',
        'publisher',
        'copyrights',
        'remarks',
        'category_id',
        'cover_image',
        'digital_copy_url',
        'barcode',
        'availability_status',
        'condition_status',
    ];

    /**
     * @var array<int, string>
     */
    protected $with = [
        'category',
    ];

    /**
     * Get the category this book belongs to.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Get inventory scan records for this book.
     */
    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class, 'book_id');
    }

    /**
     * Get favorite pivots attached to this book.
     */
    public function favoriteBooks(): HasMany
    {
        return $this->hasMany(FavoriteBook::class, 'book_id');
    }

    /**
     * Get users who marked this book as favorite.
     */
    public function favoritedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(LibraryUser::class, 'bk_favorite_books', 'book_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * Get transactions for this book.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'book_id');
    }
}
