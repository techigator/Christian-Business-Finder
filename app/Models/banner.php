<?php

namespace App\Models;

use Helper;
use Illuminate\Database\Eloquent\Model;

class banner extends Model
{
    protected $table = 'banner';
    public $primaryKey = 'id';
    protected $fillable = [
        'buisness_id',
        'user_id',
        'is_deleted',
        'name',
        'slug',
        'is_active',
        'file',
        'img',
    ];

    public function image()
    {
        // return $this->hasOne(imagetable::class, 'ref_id')->where('table_name', 'banner');
    }

    public function business(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Buisness::class, 'buisness_id', 'id');
    }
}
