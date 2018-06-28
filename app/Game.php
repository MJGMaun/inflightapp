<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    // Table Name
    protected $table = 'games';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

    protected $fillable = [
        'name', 'cover_image', 'game_apk',
    ];
}
