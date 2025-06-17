<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChoosenIndikator extends Model
{
    //
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'choosen_indikators';

    protected $fillable = [
        'id',
        'indikator_id',
        'berkas_id',
        'option',
        'score',
    ];

    public function indikator()
    {
        return $this->belongsTo(Indikator::class, 'indikator_id');
    }

    public function berkas()
    {
        return $this->belongsTo(Berkas::class, 'berkas_id');
    }

}
