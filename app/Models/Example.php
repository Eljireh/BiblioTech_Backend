<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Example extends Model
{
    public function work(): BelongsTo {
        return $this->belongsTo(Work::class);
    }
}
