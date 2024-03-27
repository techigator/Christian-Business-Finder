<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuisnessTiming extends Model
{
    use HasFactory;

    protected $fillable = [
        'buisness_id',
        'day',
        'opening_hours',
        'closing_hours',
        'availability',
    ];
}
