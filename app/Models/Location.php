<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Location extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function cards(): BelongsToMany
    {
        return $this->belongsToMany(Card::class, 'card_location');
    }
}
