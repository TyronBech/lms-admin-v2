<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Represents an inventory scan entry.
 */
class Inventory extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'bk_inventories';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'book_id',
        'is_scanned',
        'checked_at',
    ];

    /**
     * Get the book this inventory entry belongs to.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
}
