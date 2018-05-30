<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    // Table Name
    protected $table = 'posts';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;
    public function movie(){
        return $this->belongsTo('App\Movie');
    }
}
