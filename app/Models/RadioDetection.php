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
        'sonde_type',
        'geleider_frequentie',
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }
}
