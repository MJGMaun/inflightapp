<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScratchCard extends Model
{
    // Table Name
    protected $table = 'scratch_cards';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

    protected $fillable = [
        'amount', 'code', 'pin', 'card_expiration', 'card_validity', 'status',
    ];
}
