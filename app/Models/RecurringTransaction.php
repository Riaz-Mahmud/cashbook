<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecurringTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id', 'book_id', 'category_id', 'user_id',
        'amount', 'type', 'frequency', 'next_due_date', 'description'
    ];

    protected $casts = [
        'next_due_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function business() { return $this->belongsTo(Business::class); }
    public function book() { return $this->belongsTo(Book::class); }
    public function category() { return $this->belongsTo(Category::class); }
    public function user() { return $this->belongsTo(User::class); }
}
