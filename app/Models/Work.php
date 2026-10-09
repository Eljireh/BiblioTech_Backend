<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Work extends Model
{
    public function authors(): BelongsToMany {
        return $this->belongsToMany(Author::class);
    }
    
    public function examples(): BelongsToMany {
        return $this->belongsToMany(Example::class);
    }

    // Possible également d'ajouter users() pour les réservations
}
