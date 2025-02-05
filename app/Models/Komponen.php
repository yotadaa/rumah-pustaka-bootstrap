<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Komponen extends Model
{
    //
    public $incrementing = false;

    // Set key type to string (UUIDs are strings)
    protected $keyType = 'string';

    // Fillable fields
    protected $fillable = ['id', 'name', 'model'];

    // Automatically generate UUID when creating a new Berkas
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($komponen) {
            if (!$komponen->id) {
                $komponen->id = Str::uuid()->toString();
            }
        });
    }

    public function access()
    {
        return $this->hasMany(Access::class, 'komponen_id', 'id');
    }

    public function files($berkasId) {
        return $this->hasMany(File::class, 'komponen_id')->where('berkas_id', $berkasId);
    }
}
