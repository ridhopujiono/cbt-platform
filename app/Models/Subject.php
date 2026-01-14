<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
