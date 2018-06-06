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
    // public function genres(){
    //    return $this->belongsToMany(Genre::class);
    // }
}
