<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    // Table Name
    protected $table = 'episodes';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

    protected $fillable = [
        'title', 'description', 'running_time', 'episode_number', 'episode_video', 'episode_cover_image_id', 'series_id', 'season_id', 'ewallet_price',
    ];

    public function season(){
        return $this->belongsTo('App\Season', 'season_id');
    }
    public function series(){
        return $this->belongsTo('App\Series', 'series_id');
    }
    public function coverimage(){
        return $this->belongsTo('App\CoverImage', 'cover_image_id');
    }
}
