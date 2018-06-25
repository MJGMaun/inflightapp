<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    // Table Name
    protected $table = 'ads';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

    protected $fillable = [
        'name', 'ad_movie', 'roll', 'time', 'number_of_plays_needed', 'number_of_plays_remaining', 'status'
    ];
}
