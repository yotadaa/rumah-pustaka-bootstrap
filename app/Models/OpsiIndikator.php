<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpsiIndikator extends Model
{
    //
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'OpsiIndikators';

    protected $fillable = [
        'id',
        'indikator_id',
        'konten',
        'option',
        'choosen',
    ];

    public function indikator()
    {
        return $this->belongsTo(Indikator::class, 'indikator_id');
    }

}
