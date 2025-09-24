<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GPSMeasurement extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'gemeten_met',
        'data_verstuurd_naar_tekenaar',
        'signaal',
        'omgeving',
    ];

    protected $table = 'gps_measurements';
    protected $casts = [
        'data_verstuurd_naar_tekenaar' => 'boolean',
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }
}
