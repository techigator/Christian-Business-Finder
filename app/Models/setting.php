<?php
namespace App\Models;
use Helper;
use Illuminate\Database\Eloquent\Model;
class setting extends Model
{
    protected $table = 'setting';
    public $primaryKey = 'id';
    protected $fillable = [

        'user_id','is_deleted','is_active',

    ];
    public function image()
    {
        // return $this->hasOne(imagetable::class, 'ref_id')->where('table_name', 'setting');
    }
}
