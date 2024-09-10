<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class tontine extends Model
{
    use HasFactory;

    public function clientCarte(): BelongsTo
    {
        return $this->belongsTo(clientCarte::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        "montant",
        "commentaire",
        "validite",
        "action"
    ];
}
