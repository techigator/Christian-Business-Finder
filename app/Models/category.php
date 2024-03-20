<?php
namespace App\Models;
use Helper;
use Illuminate\Database\Eloquent\Model;
class category extends Model
{
    protected $table = 'category';
    public $primaryKey = 'id';
    protected $fillable = [

        'user_id','is_deleted','name','slug','is_active','img'

    ];
    public function image()
    {
        // return $this->hasOne(imagetable::class, 'ref_id')->where('table_name', 'category');
    }public function get_products($id)
    {
        return products::where("is_active",1)->where('category_id',$id)->get();
    }
     public function buisness()
    {
        return $this->hasMany(Buisness::class, 'category_id');
    }
}
