<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Models\Project;
use App\Models\Report;
use App\Models\User;
use Auth;
use App\Jobs\GenerateReportPdf;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Cable;
use App\Models\Pipe;
use App\Models\TestTrench;

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

        // Extract cables payload (array of associative arrays with maybe id)
        $cablesInput = $request->input('cables', []);
        // Extract pipes payload
        $pipesInput = $request->input('pipes', []);

        // Create the report (legacy technical spec fields still on model for backward compatibility)
        $report = Report::create($validated);

        // Optional Radio Detection
        if ($request->boolean('radio_detection_enabled') && $request->filled('radio_detection')) {
            $report->radioDetection()->create($validated['radio_detection']);
            $report->save();
        }

        // Optional Gyroscope
        if ($request->boolean('gyroscope_enabled') && $request->filled('gyroscope')) {
            $report->gyroscope()->create($validated['gyroscope']);
            $report->save();
        }

        // Optional Test Trench
        if ($request->boolean('test_trench_enabled') && $request->filled('test_trench')) {
            $report->testTrench()->create($validated['test_trench']);
            $report->save();
        }

        // Optional Ground Radar
        if ($request->boolean('ground_radar_enabled') && $request->filled('ground_radar')) {
            $report->groundRadar()->create($validated['ground_radar']);
            $report->save();
        }

        // Sync / create cables
        $cableIds = [];
        foreach ($cablesInput as $cableData) {
            if (!is_array($cableData)) { continue; }
            // Existing cable selected
            if (!empty($cableData['id'])) {
                $cableIds[] = (int)$cableData['id'];
                continue;
            }
            // New cable definition - require cable_type & material (validated already)
            if (!empty($cableData['cable_type']) && !empty($cableData['material'])) {
                $cable = Cable::firstOrCreate([
                    'cable_type' => $cableData['cable_type'],
                    'material' => $cableData['material'],
                    'diameter' => $cableData['diameter'] ?? null,
                ]);
                $cableIds[] = $cable->id;
            }
        }
        if ($cableIds) {
            $report->cables()->sync($cableIds);
        }

        // Sync / create pipes
        $pipeIds = [];
        foreach ($pipesInput as $pipeData) {
            if (!is_array($pipeData)) { continue; }
            // Existing pipe selected
            if (!empty($pipeData['id'])) {
                $pipeIds[] = (int)$pipeData['id'];
                continue;
            }
            if (!empty($pipeData['pipe_type']) && !empty($pipeData['material'])) {
                $pipe = Pipe::firstOrCreate([
                    'pipe_type' => $pipeData['pipe_type'],
                    'material' => $pipeData['material'],
                    'diameter' => $pipeData['diameter'] ?? null,
                ]);
                $pipeIds[] = $pipe->id;
            }
        }
        if ($pipeIds) {
            $report->pipes()->sync($pipeIds);
        }

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
        $report->load(['project', 'user', 'fieldWorker', 'radioDetection', 'gyroscope', 'testTrench', 'groundRadar']);

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
        $report->loadMissing(['pdf', 'cables']);

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
        $report->loadMissing(['project', 'cables']);

        $project = $report->project;
        $pdf = Pdf::loadView('reports.pdf', compact('report', 'project'));

        return $pdf->download($report->pdf->file_name);
    }

    public function regeneratePdf(Report $report) {
        $report->loadMissing(['project', 'cables']);

        // (Re)queue job to generate PDF (record will be created/updated by the job)
        GenerateReportPdf::dispatch($report);

        return back()->with('status', 'PDF is being generated. Please try again shortly.');
    }
}
