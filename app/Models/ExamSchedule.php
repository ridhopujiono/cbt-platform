<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamSchedule extends Model
{
    protected $fillable = [
        'event_id',
        'type',
        'start_at',
        'end_at',
        'duration_minutes',
        'is_active',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(ExamEvent::class, 'event_id');
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(ExamSession::class, 'schedule_id');
    }

    public function examQuestions(): HasMany
    {
        return $this->hasMany(ExamQuestion::class, 'schedule_id')
            ->orderBy('order_number');
    }

    public function isFlexible(): bool
    {
        return $this->type === 'flexible';
    }

    public function isScheduled(): bool
    {
        return $this->type === 'scheduled';
    }
}
