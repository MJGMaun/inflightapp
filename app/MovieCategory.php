<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovieCategory extends Model
{
    // Table Name
    protected $table = 'movie_categories';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;
    
    public function movies()
    {
        return $this->hasMany('App\Movie');
    }
}
