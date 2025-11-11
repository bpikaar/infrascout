<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportRequest;
use App\Models\Project;
use App\Models\Report;
use App\Models\User;
use Auth;
use App\Jobs\GenerateReportPdf;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Cable;
use App\Models\Pipe;
use App\Models\TestTrench;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use App\Models\Lance;

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
        //todo check if a cable has all fields filled in.

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

        // Optional Cable Failure
        if ($request->boolean('cable_failure_enabled') && $request->filled('cable_failure')) {
            $report->cableFailure()->create($validated['cable_failure']);
            $report->save();
        }

        // Optional GPS Measurement
        if ($request->boolean('gps_measurement_enabled') && $request->filled('gps_measurement')) {
            $report->gpsMeasurement()->create($validated['gps_measurement']);
            $report->save();
        }

        // Optional Lance
        if ($request->boolean('lance_enabled') && $request->filled('lance')) {
            $report->lance()->create($validated['lance']);
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
                // temporarily store an image so a unique filename is created
                $path = $image->store('images/reports/'.$report->id, 'public');

                // get only the filename
                $filename = basename($path);

                // overwrite the image file on disk
                $imageToResize = Image::read($image)
                    ->scaleDown(config('image.scale'), config('image.scale'));
                Storage::disk('public')->put($path,
                    $imageToResize->encodeByExtension($image->getClientOriginalExtension(), quality: config('image.quality')));

                //todo add caption to images

                // Store the image
                $report->images()->create(['path' => $filename]);
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
        $report->load([
            'project',
            'user',
            'fieldWorker',
            'radioDetection',
            'gyroscope',
            'testTrench',
            'groundRadar',
            'cableFailure',
            'gpsMeasurement',
            'lance'
        ]);
        ;
        return view('reports.show', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, Report $report)
    {
        $projects = Project::all();
        $users = User::all();
        $report->load(['cables', 'pipes', 'radioDetection', 'gyroscope', 'testTrench', 'groundRadar', 'cableFailure', 'gpsMeasurement', 'lance', 'images']);
        return view('reports.edit', compact('report', 'project', 'projects', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreReportRequest $request, Project $project, Report $report)
    {
        $validated = $request->validated();

        // Basic fields
        $report->fill($validated);
        $report->save();

        // Sync cables
        $cableIds = [];
        foreach ($request->input('cables', []) as $cableData) {
            if (!is_array($cableData)) continue;
            if (!empty($cableData['id'])) { $cableIds[] = (int)$cableData['id']; continue; }
            if (!empty($cableData['cable_type']) && !empty($cableData['material'])) {
                $cable = Cable::firstOrCreate([
                    'cable_type' => $cableData['cable_type'],
                    'material' => $cableData['material'],
                    'diameter' => $cableData['diameter'] ?? null,
                ]);
                $cableIds[] = $cable->id;
            }
        }
        $report->cables()->sync($cableIds);

        // Sync pipes
        $pipeIds = [];
        foreach ($request->input('pipes', []) as $pipeData) {
            if (!is_array($pipeData)) continue;
            if (!empty($pipeData['id'])) { $pipeIds[] = (int)$pipeData['id']; continue; }
            if (!empty($pipeData['pipe_type']) && !empty($pipeData['material'])) {
                $pipe = Pipe::firstOrCreate([
                    'pipe_type' => $pipeData['pipe_type'],
                    'material' => $pipeData['material'],
                    'diameter' => $pipeData['diameter'] ?? null,
                ]);
                $pipeIds[] = $pipe->id;
            }
        }
        $report->pipes()->sync($pipeIds);

        // Feature sections: create/update or delete if disabled
        $this->syncOptionalHasOne($report, $request, 'radio_detection_enabled', 'radio_detection', 'radioDetection');
        $this->syncOptionalHasOne($report, $request, 'gyroscope_enabled', 'gyroscope', 'gyroscope');
        $this->syncOptionalHasOne($report, $request, 'test_trench_enabled', 'test_trench', 'testTrench');
        $this->syncOptionalHasOne($report, $request, 'ground_radar_enabled', 'ground_radar', 'groundRadar');
        $this->syncOptionalHasOne($report, $request, 'cable_failure_enabled', 'cable_failure', 'cableFailure');
        $this->syncOptionalHasOne($report, $request, 'gps_measurement_enabled', 'gps_measurement', 'gpsMeasurement');
        $this->syncOptionalHasOne($report, $request, 'lance_enabled', 'lance', 'lance');

        // Delete images requested
        foreach ($request->input('delete_images', []) as $imageId) {
            $img = $report->images()->where('id', $imageId)->first();
            if ($img) {
                $diskPath = 'images/reports/'.$report->id.'/'.$img->path;
                \Storage::disk('public')->delete($diskPath);
                $img->delete();
            }
        }

        // Add new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images/reports/'.$report->id, 'public');
                $filename = basename($path);
                $imageToResize = \Intervention\Image\Laravel\Facades\Image::read($image)
                    ->scaleDown(config('image.scale'), config('image.scale'));
                \Storage::disk('public')->put($path,
                    $imageToResize->encodeByExtension($image->getClientOriginalExtension(), quality: config('image.quality')));
                $report->images()->create(['path' => $filename]);
            }
        }

        // Regenerate PDF (overwrite)
        \App\Jobs\GenerateReportPdf::dispatch($report);

        return redirect()->route('projects.reports.show', [$report->project, $report])
            ->with('status', 'Rapport bijgewerkt. PDF wordt opnieuw gegenereerd.');
    }

    protected function syncOptionalHasOne(Report $report, \Illuminate\Http\Request $request, string $toggle, string $payloadKey, string $relationMethod): void
    {
        $enabled = $request->boolean($toggle);
        $data = $request->input($payloadKey, []);
        // If disabled: delete existing
        if (!$enabled) {
            if ($report->{$relationMethod}) {
                $report->{$relationMethod}()->delete();
            }
            return;
        }
        if (empty($data)) { return; }
        // If exists update else create
        if ($report->{$relationMethod}) {
            $report->{$relationMethod}->update($data);
        } else {
            $report->{$relationMethod}()->create($data);
        }
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
