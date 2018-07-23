<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    // Table Name
    protected $table = 'movies';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;
    public function genres(){
       return $this->belongsToMany('App\Genre');
    }
    public function category(){
        return $this->belongsTo('App\MovieCategory', 'category_id');
    }
}
