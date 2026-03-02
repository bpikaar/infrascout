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
        'a_frame',
        'tdr',
        'isolatieweerstandmeting',
        'kabel_met_aftakking',
        'bijzonderheden',
        'advies',
    ];

    protected $casts = [
        'kabel_met_aftakking' => 'boolean',
        'a_frame' => 'boolean',
        'tdr' => 'boolean',
        'isolatieweerstandmeting' => 'boolean',
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

    public static function description(): ?string
    {
        return MethodDescription::where('method_type', MethodType::CableFailure->value)
            ->value('description');
    }
}
