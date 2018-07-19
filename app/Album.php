<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    // Table Name
    protected $table = 'albums';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

    protected $fillable = [
        'artist_id', 'album_name', 'cover_image_id', 'release_date', 'description', 'category',
    ];

    public function artists(){
        return $this->belongsTo('App\Artist', 'artist_id');
    }
    public function songs()
    {
        return $this->hasMany('App\Music');
    }
    public function coverimage(){
        return $this->belongsTo('App\CoverImage', 'cover_image_id');
    }
}
