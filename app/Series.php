<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
   // Table Name
    protected $table = 'series';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

    protected $fillable = [
        'title', 'cast', 'description', 'release_date', 'cover_image_id',
    ];
    public function genres(){
       return $this->belongsToMany(Genre::class);
    }
    public function seasons()
    {
        return $this->hasMany('App\Season');
    }

    public function episodes()
    {
        return $this->hasManyThrough('App\Episode', 'App\Season');
    }
    public function coverimage(){
        return $this->belongsTo('App\SeriesCoverImage', 'cover_image_id');
    }
}
