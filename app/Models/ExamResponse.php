<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamResponse extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'session_id',
        'question_id',
        'option_id',
        'is_flagged',
        'time_taken_seconds',
        'created_at',
    ];

    protected $casts = [
        'is_flagged' => 'boolean',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(ExamSession::class, 'session_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class);
    }
}
