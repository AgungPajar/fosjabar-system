<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Attendance extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'meeting_id',
        'participant_id',
        'status',
        'explanation',
    ];

    protected static function booted(): void
    {
        static::creating(function (Attendance $attendance) {
            if (empty($attendance->{$attendance->getKeyName()})) {
                $attendance->{$attendance->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class, 'meeting_id');
    }
}
