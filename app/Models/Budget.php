<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'category_id',
        'month',
        'amount',
    ];

    protected $casts = [
        'month' => 'date:Y-m-01',
        'amount' => 'decimal:2',
    ];

    public function business() { return $this->belongsTo(Business::class); }
    public function category() { return $this->belongsTo(Category::class); }
}
