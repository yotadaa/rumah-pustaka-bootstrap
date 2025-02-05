<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    //
    protected $fillable = [
        'path', 'folder', 'filename', 'komponen_id', 'berkas_id', 'role_id'
    ];
}
