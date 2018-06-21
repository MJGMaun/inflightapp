<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    // Table Name
    protected $table = 'product_categories';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

    public function subcategories()
    {
        return $this->hasMany('App\ProductSubCategory');
    }
    public function products()
    {
        return $this->hasManyThrough('App\Product', 'App\ProductSubCategory');
    }
}
