<?php
namespace App\Models;
use Helper;
use Illuminate\Database\Eloquent\Model;
class banner extends Model
{
    protected $table = 'banner';
    public $primaryKey = 'id';
    protected $fillable = [

        'user_id','is_deleted','name','slug','is_active','img'

    ];
    public function image()
    {
        // return $this->hasOne(imagetable::class, 'ref_id')->where('table_name', 'banner');
    }
}
