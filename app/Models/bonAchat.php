<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class bonAchat extends Model
{
    use HasFactory;

    public function facture(): BelongsTo
    {
        return $this->belongsTo(facture::class);
    }
    public function clientCarte(): BelongsTo
    {
        return $this->belongsTo(clientCarte::class);
    }
    protected $fillable = [
        'point',
        'actif',
        'montantGlobal',
    ];
}
