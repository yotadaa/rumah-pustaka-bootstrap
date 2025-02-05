<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berkas extends Model
{
    // Disable auto-incrementing
    public $incrementing = false;

    // Set key type to string (UUIDs are strings)
    protected $keyType = 'string';

    // Fillable fields
    protected $fillable = ['id', 'name', 'model'];

    // Automatically generate UUID when creating a new Berkas
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($berkas) {
            // Generate UUID for 'id' if it's not already set
            if (!$berkas->id) {
                $berkas->id = Str::uuid()->toString();
            }
        });
    }

    public function komponen()
    {
        return $this->hasOne(KomponenIso::class, 'id_berkas', 'id',);
    }
}
