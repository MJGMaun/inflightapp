<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    // Table Name
    protected $table = 'movies';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;
    public function genres(){
       return $this->belongsToMany(Genre::class);
    }
    // public function getMovieGenres(){
    //    return null !== $this->genres()->where('id', $this->movie_id)->first()->name;
    // }
}
