<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class inquiry extends Model
{
    protected $table = 'inquiry';
    public $primaryKey = 'id';
    protected $fillable = ['name', 'email', 'phonenumber', 'message', 'url'];
}
