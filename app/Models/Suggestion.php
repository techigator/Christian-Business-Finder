<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    use HasFactory;

    protected $table = 'suggestions';
    protected $fillable = [
        'buisness_id'
    ];

    public function buisness()
    {
        return $this->belongsTo(Buisness::class, 'buisness_id');
    }
}
