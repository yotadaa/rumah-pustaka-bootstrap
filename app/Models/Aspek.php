<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aspek extends Model
{
    //
    public $incrementing = false;

    // Set key type to string (UUIDs are strings)
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'komponen_id',
        'berkas_id',
        'name',
        'no'
    ];

    public function komponen()
    {
        return $this->belongsTo(Komponen::class, 'komponen_id');
    }


}
