<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Author extends Model
{
    public function works(): BelongsToMany {
        return $this->belongsToMany(Work::class);
    } 
}
