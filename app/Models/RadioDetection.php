<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RadioDetection extends Model
{
    /** @use HasFactory<\Database\Factories\RadioDetectionFactory> */
    use HasFactory;

    protected $fillable = [
        'report_id',
        'signaal_op_kabel',
        'signaal_sterkte',
        'frequentie',
        'aansluiting',
        'zender_type',
        'sonde_type', // only when "signaal met sonde" checkbox is ticked in UI
        'geleider_frequentie', // only when "signaal met geleider" checkbox is ticked in UI
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }
}
