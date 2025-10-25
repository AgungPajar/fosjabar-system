<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    // migration uses uuid primary key
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'slug',
        'title',
        'subtitle',
        'deskripsi',
        'photo',
        'author',
    ];

    // generate uuid id when creating
    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    // use slug for route model binding
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Tags relation (many-to-many via news_tags_pivots)
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'news_tags_pivots', 'news_id', 'tag_id');
    }
}
