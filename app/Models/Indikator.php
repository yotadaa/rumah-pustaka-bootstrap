<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Indikator extends Model
{
    //
    protected $fillable = [
        'content','aspek_id','komponen_id','berkas_id','multiple'
    ];
}
