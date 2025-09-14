<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Models\Project;
use App\Models\Report;
use App\Models\User;
use Auth;
use Spatie\LaravelPdf\Facades\Pdf;

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
                $report->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('projects.show', $report->project);
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
        Pdf::view('reports.download', compact('report'))
//            ->format('a4')
            ->save('invoice.pdf')
            ->download('invoice.pdf');
    }
}
