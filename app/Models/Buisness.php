<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buisness extends Model
{
    use HasFactory;

    protected $table = 'buisness';

    protected $fillable = [
        'user_id',
        'type',
        'buisness_type',
        'name',
        'service',
        'ratings',
        'images',
        'cover_image',
        'thumbnail',
        'opening_hours',
        'details',
        'location',
        'longitude',
        'latitude',
        'category_id',
        'phone_number',
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

    public function likes()
    {
        return $this->hasMany(Like::class, 'buisness_id');
    }

    public function business_timing()
    {
        return $this->hasMany(BuisnessTiming::class, 'buisness_id');
    }

    public function banner(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Buisness::class, 'buisness_id', 'id');
    }
}
