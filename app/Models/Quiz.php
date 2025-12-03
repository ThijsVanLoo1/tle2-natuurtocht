<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quiz extends Model
{
    protected $table = 'quiz';

    protected $guarded = [];

    protected $casts = [
        'answers' => 'array',
    ];

    public $timestamps = false; // zet op true als jij timestamps toegevoegd hebt

    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class);
    }
}
