<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buisness extends Model
{
    use HasFactory;

    protected $table = 'buisness';

    protected $fillable = [
        'service',
        'name',
        'ratings',
        'images',
        'thumbnail',
        'opening_hours',
        'details',
        'location',
        'longitude',
        'latitude',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rating()
    {
        return $this->hasMany(Rating::class);
    }

    public function averageRating()
    {
        // Value example without point 2
        // return round($this->rating()->avg('ratings'));

        // Value example with point 1.625
        $ratings = $this->rating();
        $totalRatings = $ratings->count();
        $filteredRatings = $ratings->where('flag', 1)->get();
        $liked_flag = $filteredRatings->count();
        if ($totalRatings === 0) {
            $averageRating = 0;
        } else {
            $averageRating = ($liked_flag / $totalRatings) * 100;
        }
        return $averageRating;

        // return $this->rating()->avg('ratings');
    }

    // public function suggestions()
    // {
    //     return $this->hasMany(Suggestion::class, 'buisness_id');
    // }
}
