<?php

namespace App\Http\Controllers;

use App\Enums\MethodType;
use App\Http\Requests\StoreReportRequest;
use App\Jobs\GenerateReportPdf;
use App\Models\Cable;
use App\Models\Client;
use App\Models\Pipe;
use App\Models\Report;
use App\Models\User;
use Auth;
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
    public function create(Client $client)
    {
        $clients = Client::all();
        $users = User::all();

        return view('reports.create', compact('client', 'clients', 'users'));
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

        // Verwerk alle optionele meetmethoden
        $methods = [
            'radio_detection' => 'radioDetection',
            'gyroscope' => 'gyroscope',
            'test_trench' => 'testTrench',
            'ground_radar' => 'groundRadar',
            'cable_failure' => 'cableFailure',
            'gps_measurement' => 'gpsMeasurement',
            'lance' => 'lance',
        ];

        foreach ($methods as $requestKey => $relationMethod) {
            if ($request->boolean("{$requestKey}_enabled") && $request->filled($requestKey)) {
                $methodModel = $report->$relationMethod()->create($validated[$requestKey]);

                // Specifieke afhandeling voor boolean velden in cable_failure
                if ($requestKey === 'cable_failure') {
                    $methodModel->a_frame = $request->has('cable_failure.a_frame') ? 1 : 0;
                    $methodModel->tdr = $request->has('cable_failure.tdr') ? 1 : 0;
                    $methodModel->isolatieweerstandmeting = $request->has('cable_failure.isolatieweerstandmeting') ? 1 : 0;
                    $methodModel->save();
                }
            }
        }

        // Sync / create cables
        $cableIds = [];
        foreach ($cablesInput as $cableData) {
            if (!is_array($cableData)) {
                continue;
            }
            // Existing cable selected
            if (!empty($cableData['id'])) {
                $cableIds[] = (int) $cableData['id'];
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
            if (!is_array($pipeData)) {
                continue;
            }
            // Existing pipe selected
            if (!empty($pipeData['id'])) {
                $pipeIds[] = (int) $pipeData['id'];
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

        // Handle general images uploads
        if ($request->hasFile('images')) {
            $this->processAndStoreImages($report, $request->file('images'));
        }

        // Handle method-specific images
        if ($request->has('method_images') && is_array($request->method_images)) {
            foreach ($request->method_images as $method => $images) {
                if (is_array($images)) {
                    $methodType = MethodType::tryFrom($method);
                    if ($methodType) {
                        $this->processAndStoreImages($report, $images, $methodType);
                    }
                }
            }
        }

        // Dispatch PDF generation job
        GenerateReportPdf::dispatch($report);

        return redirect()->route('clients.show', $report->client)
            ->with('status', 'PDF is being prepared. You can download it once it is ready.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client, Report $report)
    {
        // Load the report with its relationships
        $report->load([
            'client',
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
    public function edit(Client $client, Report $report)
    {
        $clients = Client::all();
        $users = User::all();
        $report->load(['cables', 'pipes', 'radioDetection', 'gyroscope', 'testTrench', 'groundRadar', 'cableFailure', 'gpsMeasurement', 'lance', 'images']);
        return view('reports.edit', compact('report', 'client', 'clients', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreReportRequest $request, Client $client, Report $report)
    {
        $validated = $request->validated();

        // Basic fields
        $report->fill($validated);
        $report->save();

        // Sync cables
        $cableIds = [];
        foreach ($request->input('cables', []) as $cableData) {
            if (!is_array($cableData))
                continue;
            if (!empty($cableData['id'])) {
                $cableIds[] = (int) $cableData['id'];
                continue;
            }
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
            if (!is_array($pipeData))
                continue;
            if (!empty($pipeData['id'])) {
                $pipeIds[] = (int) $pipeData['id'];
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
        $report->pipes()->sync($pipeIds);

        // Verwerk alle optionele meetmethoden dynamisch
        $methods = [
            'radio_detection' => 'radioDetection',
            'gyroscope' => 'gyroscope',
            'test_trench' => 'testTrench',
            'ground_radar' => 'groundRadar',
            'cable_failure' => 'cableFailure',
            'gps_measurement' => 'gpsMeasurement',
            'lance' => 'lance',
        ];

        // Update method status
        foreach ($methods as $requestKey => $relationMethod) {
            if ($request->boolean("{$requestKey}_enabled")) {
                if ($request->filled($requestKey)) {
                    $methodModel = $report->$relationMethod()->updateOrCreate(
                        ['report_id' => $report->id],
                        $validated[$requestKey]
                    );

                    // Specifieke afhandeling voor boolean velden in cable_failure
                    if ($requestKey === 'cable_failure') {
                        $methodModel->a_frame = $request->has('cable_failure.a_frame') ? 1 : 0;
                        $methodModel->tdr = $request->has('cable_failure.tdr') ? 1 : 0;
                        $methodModel->isolatieweerstandmeting = $request->has('cable_failure.isolatieweerstandmeting') ? 1 : 0;
                        $methodModel->save();
                    }
                }
            } else {
                $report->$relationMethod()->delete();
            }
        }

        // Delete images requested
        foreach ($request->input('delete_images', []) as $imageId) {
            $img = $report->images()->where('id', $imageId)->first();
            if ($img) {
                $diskPath = 'images/reports/' . $report->id . '/' . $img->path;
                \Storage::disk('local')->delete($diskPath);
                $img->delete();
            }
        }

        // Add new general images
        if ($request->hasFile('images')) {
            $this->processAndStoreImages($report, $request->file('images'));
        }

        // Add new method-specific images
        if ($request->has('method_images') && is_array($request->method_images)) {
            foreach ($request->method_images as $method => $images) {
                if (is_array($images)) {
                    $methodType = MethodType::tryFrom($method);
                    if ($methodType) {
                        $this->processAndStoreImages($report, $images, $methodType);
                    }
                }
            }
        }

        // Regenerate PDF (overwrite)
        \App\Jobs\GenerateReportPdf::dispatch($report);

        return redirect()->route('clients.reports.show', [$report->client, $report])
            ->with('status', 'Rapport bijgewerkt. PDF wordt opnieuw gegenereerd.');
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
        if ($filePath && \Storage::disk('local')->exists($filePath)) {
            $downloadName = $report->pdf?->file_name ?? basename($filePath);
            return response()->download(storage_path("app/private/{$filePath}"), $downloadName);
        }

        // (Re)queue job to generate PDF (record will be created/updated by the job)
        GenerateReportPdf::dispatch($report);

        return back()->with('status', 'PDF is being generated. Please try again shortly.');
    }

    public function directDownload(Report $report)
    {
        $report->loadMissing(['client', 'cables']);

        $client = $report->client;
        $pdf = Pdf::loadView('reports.pdf', compact('report', 'client'));

        return $pdf->download($report->pdf->file_name);
    }

    public function regeneratePdf(Report $report)
    {
        $report->loadMissing(['client', 'cables']);

        // (Re)queue job to generate PDF (record will be created/updated by the job)
        GenerateReportPdf::dispatch($report);

        return back()->with('status', 'PDF is being generated. Please try again shortly.');
    }

    /**
     * Process and store an array of uploaded images, automatically converting HEIC/any format to JPG.
     *
     * @param Report $report
     * @param array $images
     * @param MethodType|null $method
     * @return void
     */
    private function processAndStoreImages(Report $report, array $images, ?MethodType $method = null): void
    {
        foreach ($images as $image) {
            $filename = \App\Services\ImageService::processAndStore($image, 'images/reports/' . $report->id);

            // Create record
            $report->images()->create([
                'path' => $filename,
                'method' => $method,
            ]);
        }
    }
}
