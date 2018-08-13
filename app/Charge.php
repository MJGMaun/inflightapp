<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    // Table Name
    protected $table = 'charges';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

    // public function subcategories()
    // {
    //     return $this->hasMany('App\ProductSubCategory');
    // }
    // public function products()
    // {
    //     return $this->hasManyThrough('App\Product', 'App\ProductSubCategory');
    // }
}
