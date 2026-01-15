<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamSession extends Model
{
    protected $fillable = [
        'user_id',
        'schedule_id',
        'start_time',
        'end_time',
        'status',
        'last_heartbeat',
        'score',
        'correct_count',
        'raw_score',
        'final_score'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'last_heartbeat' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(ExamSchedule::class);
    }

    public function responses(): HasMany
    {
        return $this->hasMany(ExamResponse::class, 'session_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(ExamLog::class, 'session_id');
    }
}
