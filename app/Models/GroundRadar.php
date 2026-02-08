<?php

namespace App\Models;

use App\Enums\MethodType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroundRadar extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'radarbeeld',
        'ingestelde_detectiediepte',
    ];

    protected $casts = [
        'ingestelde_detectiediepte' => 'decimal:2',
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

    public static function description(): ?string {
        return \DB::table('method_descriptions')
            ->where('method_type', MethodType::GroundRadar->value)
            ->value('description');
    }
}
