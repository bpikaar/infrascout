<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Models\Project;
use App\Models\Report;
use App\Models\User;
use Auth;
use App\Jobs\GenerateReportPdf;
use App\Models\ReportPdf;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        $projects = Project::all();
        $users = User::all();

        return view('reports.create', compact('project', 'projects', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReportRequest $request)
    {
        $validated = $request->validated();

        // Add the authenticated user as the creator
        $validated['user_id'] = Auth::id();

        // Create the report
        $report = Report::create($validated);

        // Handle image uploads through relationship
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images/reports/'.$report->id, 'public');
                // delete the prefix
                $path = str_replace('images/reports/'.$report->id.'/', '', $path);
                //todo add caption to images
                $report->images()->create(['path' => $path]);
            }
        }

//        $projectName = preg_replace(
//            '/[^A-Za-z0-9\-_]/', '',
//            str_replace(' ', '-', $report->project->name)
//        );
//        $reportName = "Rapportage_{$report->id}_{$projectName}_{$report->updated_at->toDateString()}.pdf";
//        $filePath = "reports/pdfs/$reportName";
//        // Ensure a ReportPdf record exists and stays up-to-date
//        ReportPdf::firstOrCreate(
//            ['report_id' => $report->id],
//            ['file_path' => $filePath, 'file_name' => $reportName]
//        );

        // Dispatch PDF generation job
        GenerateReportPdf::dispatch($report);

        return redirect()->route('projects.show', $report->project)
            ->with('status', 'PDF is being prepared. You can download it once it is ready.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project, Report $report)
    {
        // Load the report with its relationships
        $report->load(['project', 'user', 'fieldWorker']);

        return view('reports.show', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReportRequest $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        //
    }

    public function download(Report $report)
    {
        $report->loadMissing('pdf');
        $filePath = $report->pdf?->file_path;

        // Return the existing pdf from disk if present
        if ($filePath && \Storage::disk('public')->exists($filePath)) {
            $downloadName = $report->pdf?->file_name ?? basename($filePath);
            return response()->download(storage_path("app/public/{$filePath}"), $downloadName);
        }

        // (Re)queue job to generate PDF (record will be created/updated by the job)
        GenerateReportPdf::dispatch($report);

        return back()->with('status', 'PDF is being generated. Please try again shortly.');
    }

    public function directDownload(Report $report) {
        $report->loadMissing('project');

        $project = $report->project;
        $pdf = Pdf::loadView('reports.pdf', compact('report', 'project'));

        return $pdf->download($report->pdf->file_name);
    }
}
