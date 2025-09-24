<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestTrench extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'proefsleuf_gemaakt',
        'manier_van_graven',
        'type_grondslag',
        'klic_melding_gedaan',
        'klic_nummer',
        'locatie',
        'doel',
        'bevindingen',
    ];

    protected $casts = [
        'proefsleuf_gemaakt' => 'boolean',
        'klic_melding_gedaan' => 'boolean',
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }
}
