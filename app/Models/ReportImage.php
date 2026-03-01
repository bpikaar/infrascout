<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportImage extends Model
{
    protected $fillable = [
        'report_id',
        'path',
        'caption',
        'method',
    ];

    protected function casts(): array
    {
        return [
            'method' => \App\Enums\MethodType::class,
        ];
    }

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }
}
