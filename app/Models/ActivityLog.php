<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'action', 'user_id', 'business_id', 'subject_type', 'subject_id', 'details'
    ];

    protected $casts = [
        'details' => 'array',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function business() { return $this->belongsTo(Business::class); }
}
