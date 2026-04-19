<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Represents a favorite-book pivot record.
 */
class FavoriteBook extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'bk_favorite_books';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'book_id',
    ];

    /**
     * Get the owning user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(LibraryUser::class, 'user_id');
    }

    /**
     * Get the favorited book.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
}
