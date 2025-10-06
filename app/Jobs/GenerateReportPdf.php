<?php

namespace App\Jobs;

use App\Models\Report;
use App\Models\ReportPdf;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GenerateReportPdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Report $report;


    /**
     * Generate a new report PDF and create or update the path of the pdf file in de database
     * @param Report $report
     */
    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    public function handle(): void
    {
        $report = $this->report->fresh(['project', 'user', 'fieldWorker', 'images']);
        $project = $report->project;

        $pdf = Pdf::loadView('reports.pdf', compact('report', 'project'));

        $projectName = preg_replace(
            '/[^A-Za-z0-9\-_]/', '',
            str_replace(' ', '-', $report->project->name)
        );
        $reportName = "Rapportage_{$report->id}_{$projectName}_{$report->updated_at->toDateString()}.pdf";
        $filePath = "reports/pdfs/$reportName";

        Storage::disk('public')->put($filePath, $pdf->output());

        // Ensure a ReportPdf record exists and stays up-to-date
        ReportPdf::updateOrCreate(
            ['report_id' => $report->id],
            ['file_path' => $filePath, 'file_name' => $reportName]
        );
    }
}
