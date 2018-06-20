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
        'album_name', 'cover_image_id',
    ];

    public function artists(){
        // return $this->belongsTo('App\Artist', 'artist_id');
        return $this->belongsTo('App\Artist', 'artist_id');
    }
    public function songs()
    {
        return $this->hasMany('App\Music');
        // return $this->belongsToMany('App\Album', 'artist_id');
    }
    public function coverimage(){
        return $this->belongsTo('App\CoverImage', 'cover_image_id');
    }
}
