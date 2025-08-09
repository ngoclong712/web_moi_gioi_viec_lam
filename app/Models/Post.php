<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'job_title',
        'city',
        'status',
        'user_id',
        'company_id',
    ];

    protected static function booted()
    {
        static::creating(static function ($object) {
           $object->user_id = auth()->user()->id;
        });
    }
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'job_title'
            ]
        ];
    }
}
