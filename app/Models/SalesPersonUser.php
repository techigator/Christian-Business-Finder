<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesPersonUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'referral_id',
        'coupon_code',
        'referral_code',
    ];

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sales_person(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'referral_code', 'referral_code');
    }
}
