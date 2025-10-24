<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Activity extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'desc',
        'location',
        'datetime',
        'is_finished',
    ];

    protected $casts = [
        'datetime' => 'datetime',
        'is_finished' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Activity $activity) {
            if (empty($activity->{$activity->getKeyName()})) {
                $activity->{$activity->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'meeting_id');
    }
}
