<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportPdf extends Model
{
    protected $fillable = [
        'report_id',
        'file_path',
        'file_name',
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }
}
