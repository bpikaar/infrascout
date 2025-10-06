<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CableFailure extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'type_storing',
        'locatie_storing',
        'methode_vaststelling',
        'kabel_met_aftakking',
        'bijzonderheden',
        'advies',
    ];

    protected $casts = [
        'kabel_met_aftakking' => 'boolean',
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }
}
