<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSubCategory extends Model
{
    // Table Name
    protected $table = 'product_sub_categories';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

    public function category(){
        // return $this->belongsTo('App\Artist', 'artist_id');
        return $this->belongsTo('App\ProductCategory');
    }

}
