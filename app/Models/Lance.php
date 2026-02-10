<?php

namespace App\Models;

use App\Enums\MethodType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lance extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'aanprikdiepte',
    ];

    protected $casts = [
        'aanprikdiepte' => 'decimal:2',
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

    public static function description(): ?string {
        return MethodDescription::where('method_type', MethodType::Lance->value)
            ->value('description');
    }
}
