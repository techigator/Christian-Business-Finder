<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    protected $table = 'likes';

    protected $fillable = [
        'user_id',
        'buisness_id',
    ];

    // public function suggestion(){
    //     return $this->belongsTo(Suggestion::class , 'suggestion_id');
    // }

    public function buisness()
    {
        return $this->belongsTo(Buisness::class, 'buisness_id', 'id');
    }
}
