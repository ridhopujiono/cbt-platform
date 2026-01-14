<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'session_id',
        'event_type',
        'log_data',
        'created_at',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(ExamSession::class, 'session_id');
    }
}
