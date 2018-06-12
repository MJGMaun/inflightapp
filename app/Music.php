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
    public function albums(){
        // return $this->belongsTo('App\Artist', 'artist_id');
        return $this->belongsTo('App\Album');
    }
}
