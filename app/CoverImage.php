<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoverImage extends Model
{
     // Table Name
    protected $table = 'cover_images';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;
    public function album()
    {
        return $this->hasOne('App\Album');
    }
    public function musics(){
        return $this->hasMany('App\Music');
    }
}
