<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class newsletter extends Model
{
    protected $table = 'newsletter';
    public $primaryKey = 'id';
    protected $fillable = ['email'];
}
