<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $dates = ['subscription_expires_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'coupon_id',
        'type',
        'referral_code',
        'created_by',
        'login_from',
        'name',
        'email',
        'number',
        'date_of_birth',
        'gender',
        'buisness_name',
        'buisness_description',
        'buisness_categories',
        'home_church_name',
        'home_church_address',
        'address',
        'latitude',
        'longitude',
        'web_link',
        'denomination',
        'view_as',
        'country',
        'city',
        'state',
        'want_to_see',
        'profile_image',
        'cover_image',
        'email_verified_at',
        'email_verified',
        'email_verified_code',
        'forget_password_code',
        'password',
        'fcm_token',
        'remember_token',
        'subscription_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function business(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Buisness::class);
    }

    public function sales_person(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SalesPersonUser::class, 'user_id');
    }

    public function referral_person(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SalesPersonUser::class, 'referral_code', 'referral_code');
    }

    public function coupon(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Coupon::class, 'user_id');
    }

    public function payment(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Payment::class, 'user_id');
    }

    public function isPaidMember(): bool
    {
        return $this->subscription_expires_at && $this->subscription_expires_at->isFuture();
    }

    public function makePaidMember()
    {
        $this->update(['subscription_expires_at' => Carbon::now()->addMonth()]);
    }

    public function expireSubscription()
    {
        $this->update(['subscription_expires_at' => null]);
    }
}
