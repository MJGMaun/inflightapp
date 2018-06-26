<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeriesCoverImage extends Model
{
     // Table Name
    protected $table = 'series_cover_images';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;
    public function series()
    {
        return $this->hasOne('App\Series');
    }
    public function seasons()
    {
        return $this->hasOne('App\Season');
    }
    public function episodes(){
        return $this->hasMany('App\Episode');
    }
}
