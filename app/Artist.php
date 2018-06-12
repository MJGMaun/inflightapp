<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    // Table Name
    protected $table = 'artists';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

    public function albums()
    {
        return $this->belongsToMany(Album::class);
        // return $this->belongsToMany('App\Album', 'artist_id');
    }
}
