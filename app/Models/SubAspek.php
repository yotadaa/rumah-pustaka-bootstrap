<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubAspek extends Model
{
    //
    public $incrementing = false;
    protected $table = 'sub-aspeks';

    // Set key type to string (UUIDs are strings)
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'aspek_id',
        'name',
        'no'
    ];
}
