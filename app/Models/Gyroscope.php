<?php

namespace App\Models;

use App\Enums\MethodType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gyroscope extends Model
{
    /** @use HasFactory<\Database\Factories\GyroscopeFactory> */
    use HasFactory;

    protected $fillable = [
        'report_id',
        'type_boring',
        'intredepunt',
        'uittredepunt',
        'lengte_trace',
        'bodemprofiel_ingemeten_met_gps',
        'diameter_buis',
        'materiaal',
        'ingemeten_met',
        'bijzonderheden',
    ];

    protected $casts = [
        'bodemprofiel_ingemeten_met_gps' => 'boolean',
        'lengte_trace' => 'decimal:2',
        'diameter_buis' => 'decimal:2',
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

    public static function description(): ?string {
        return MethodDescription::where('method_type', MethodType::Gyroscope->value)
            ->value('description');
    }
}
