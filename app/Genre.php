<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    // Table Name
    protected $table = 'genres';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;
    public function movies(){
        return $this->belongsToMany('Movie');
    }
    public function series(){
        return $this->belongsToMany('Series');
    }
}
