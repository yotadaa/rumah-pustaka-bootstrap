<?php

namespace App\Models;

use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use Illuminate\Database\Eloquent\Model;

class Indikator extends Model
{
    use HasRichText;

    /**
     * The dynamic rich text attributes.
     *
     * @var array<int|string, string>
     */
    protected $richTextAttributes = [
        'description',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'sub',
        'sub_id',
        'content',
        'aspek_id',
        'sub_aspek_id',
        'multiple',
        'no',
    ];
}
