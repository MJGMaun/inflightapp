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

    public function artists(){
        // return $this->belongsTo('App\Artist', 'artist_id');
        return $this->belongsTo('App\Artist');
    }
    public function songs()
    {
        return $this->belongsToMany(Music::class);
        // return $this->belongsToMany('App\Album', 'artist_id');
    }
}
