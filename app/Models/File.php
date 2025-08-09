<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /** @use HasFactory<\Database\Factories\FileFactory> */
    use HasFactory;

    protected $fillable = [
        'post_id',
        'link',
        'type',
        'user_id',
    ];

    public $timestamps = false;

    protected static function booted()
    {
        static::creating(static function ($object) {
            $object->user_id = auth()->user()->id;
        });
    }
}
