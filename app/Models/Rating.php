<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'buisness_id',
        'ratings',
        'flag',
    ];

    public function business()
    {
        return $this->belongsTo(Buisness::class);
    }
}
