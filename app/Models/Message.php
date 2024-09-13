<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Message extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sender_id',
        'recipient_id',
        'content',
        'flag',
    ];

    /**
     * Get the sender of the message.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the recipient of the message.
     */
    public function recipient()
    {
        return $this->belongsTo(Buisness::class, 'recipient_id', 'user_id');
    }

    public function sender_business()
    {
        return $this->belongsTo(Buisness::class, 'sender_id', 'user_id');
    }

    public function senderHasBlockedRecipient(): HasOne
    {
        return $this->hasOne(BlockedUser::class, 'from_user', 'sender_id')
            ->where('to_user', $this->recipient_id)
            ->where('status', true);
    }

    public function recipientHasBlockedSender(): HasOne
    {
        return $this->hasOne(BlockedUser::class, 'from_user', 'recipient_id')
            ->where('to_user', $this->sender_id)
            ->where('status', true);
    }
}
