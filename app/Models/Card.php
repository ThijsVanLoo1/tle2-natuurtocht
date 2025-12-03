<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Card extends Model
{
    protected $guarded = [];

    protected $casts = [
        'properties' => 'array',
    ];

    public $timestamps = false; // zet op true / verwijder als je timestamps hebt in cards

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function seasons(): BelongsToMany
    {
        return $this->belongsToMany(Season::class, 'card_season');
    }

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Location::class, 'card_location');
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class, 'card_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_cards')
            ->withPivot(['acquired_at', 'image_url', 'is_shiny']);
    }
}
