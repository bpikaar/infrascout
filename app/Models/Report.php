<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Report extends Model
{
    /**
     * @var string[]
     */
    protected $casts = [
        'date_of_work' => 'datetime', // will be cast to Carbon
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'project_id',
        'date_of_work',
        'field_worker',
        'cable_type',
        'material',
        'diameter',
        'description',
        'work_hours',
        'travel_time',
    ];
    /**
     * Get the images for the report.
     */
    public function images()
    {
        return $this->hasMany(ReportImage::class);
    }

    /**
     * Get the project that owns the report.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user that created the report.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the field worker for the report.
     */
    public function fieldWorker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'field_worker');
    }

    /**
     * Generated PDF for this report.
     */
    public function pdf()
    {
        return $this->hasOne(ReportPdf::class);
    }

    /**
     * Cables associated with this report.
     */
    public function cables()
    {
        return $this->belongsToMany(Cable::class);
    }

    /**
     * Pipes associated with this report.
     */
    public function pipes()
    {
        return $this->belongsToMany(Pipe::class);
    }

    /**
     * Radio detection associated with this report.
     */
    public function radioDetection(): HasOne
    {
        // FK lives on radio_detections.report_id
        return $this->hasOne(RadioDetection::class);
    }

    /**
     * Gyroscope associated with this report.
     */
    public function gyroscope(): HasOne
    {
        return $this->hasOne(Gyroscope::class);
    }

    /**
     * Test trench associated with this report.
     */
    public function testTrench(): HasOne
    {
        return $this->hasOne(TestTrench::class);
    }

    /**
     * Ground Radar associated with this report.
     */
    public function groundRadar(): HasOne
    {
        return $this->hasOne(GroundRadar::class);
    }

    /**
     * Cable failure associated with this report.
     */
    public function cableFailure(): HasOne
    {
        return $this->hasOne(CableFailure::class);
    }

    /**
     * GPS measurement associated with this report.
     */
    public function gpsMeasurement(): HasOne
    {
        return $this->hasOne(GPSMeasurement::class);
    }
}
