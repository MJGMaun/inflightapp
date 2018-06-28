<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    // Table Name
    protected $table = 'seasons';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

    protected $fillable = [
        'series_id', 'series_number', 'season_cover_image_id', 
    ];

    public function series(){
        return $this->belongsTo('App\Series', 'series_id');
    }
    public function episodes()
    {
        return $this->hasMany('App\Episode');
    }
    public function seriescoverimage(){
        return $this->belongsTo('App\SeriesCoverImage', 'season_cover_image_id');
    }
}
