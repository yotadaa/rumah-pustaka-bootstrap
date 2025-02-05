<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KomponenIso extends Model
{
    // Disable auto-incrementing
    public $incrementing = false;

    // Set key type to string (UUIDs are strings)
    protected $keyType = 'string';

    // Fillable fields
    protected $fillable = ['id', 'name', 'model', 'id_berkas'];

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
    public function files() {
        return $this->hasMany(File::class, 'komponen_id')->where('berkas_id', $this->id_berkas);
    }



}
