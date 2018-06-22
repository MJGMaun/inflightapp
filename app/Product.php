<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Table Name
    protected $table = 'products';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

    public function subcategory(){
        return $this->belongsTo('App\ProductSubCategory', 'product_sub_category_id');
    }

}
