<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamEvent extends Model
{
    protected $fillable = [
        'title',
        'description',
    ];

    public function schedules(): HasMany
    {
        return $this->hasMany(ExamSchedule::class, 'event_id');
    }
}
