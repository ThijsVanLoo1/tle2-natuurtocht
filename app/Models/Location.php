<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Location extends Model
{
    protected $guarded = [];

    public $timestamps = false; // zet op true als jij wél created_at/updated_at hebt

    public function cards(): BelongsToMany
    {
        return $this->belongsToMany(Card::class, 'card_location');
    }
}
