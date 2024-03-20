<?php

namespace App\Models;

use Helper;
use Auth;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    protected $table = 'products';
    public $primaryKey = 'id';

    public function image()
    {
        // return $this->hasOne(imagetable::class, 'ref_id')->where('table_name', 'product');
    }
    public function get_category($id = "")
    {
        return category::where('id', $id)->first();
    }
    public function get_wishlist($id)
    {
        return product_wishlist::where('product_id', $id)->where('user_id', Auth::user()->id)->first();
    }
    public function get_product_used($id)
    {
        return product_used::where('product_id', $id)->where('user_id', Auth::user()->id)->first();
    }
        public function getMultiImg()
    {
         return $this->hasMany(product_imgs::class, 'product_id');
    }
}
