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

    protected $fillable = [
        'artist_name',
    ];

    public function albums()
    {
        return $this->hasMany('App\Album');
        // return $this->hasManyThrough('App\Album', 'App\Music', 'artist_id');
        // return $this->belongsToMany('App\Album', 'artist_id');
    }
}
