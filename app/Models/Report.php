<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'reporting_to',
        'reporting_by',
        'content',
    ];

    public function reportedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporting_by');
    }

    public function reportedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporting_to');
    }
}
