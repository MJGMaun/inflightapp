<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    // Table Name
    protected $table = 'musics';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

    protected $fillable = [
        'title', 'album_id', 'genre', 'cover_image_id', 'music_song',
    ];

    public function albums(){
        // return $this->belongsTo('App\Artist', 'artist_id');
        return $this->belongsTo('App\Album', 'artist_id');
    }
    public function coverimage(){
        return $this->belongsTo('App\CoverImage', 'cover_image_id');
    }
}
