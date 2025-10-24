<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Generation extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'participants_id',
        'name',
        'singkatan',
        'started_at',
        'ended_at',
        'is_active',
    ];

    protected $casts = [
        'started_at' => 'date',
        'ended_at' => 'date',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Generation $generation) {
            if (empty($generation->{$generation->getKeyName()})) {
                $generation->{$generation->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class, 'generations_id');
    }

    public function leader(): BelongsTo
    {
        return $this->belongsTo(Participant::class, 'participants_id');
    }
}
