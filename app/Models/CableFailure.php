<?php

namespace App\Models;

use App\Enums\MethodType;
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

    public static function description(): ?string {
        return MethodDescription::where('method_type', MethodType::CableFailure->value)
            ->value('description');
    }

    public static function methodDescriptionFor(?string $method): ?string
    {
        if (!$method) {
            return null;
        }

        $methodType = match ($method) {
            'A-frame' => MethodType::AFrame->value,
            'TDR' => MethodType::TDR->value,
            'Meggeren' => MethodType::Meggeren->value,
            default => null,
        };

        if (!$methodType) {
            return null;
        }

        return MethodDescription::where('method_type', $methodType)
            ->value('description');
    }
}
