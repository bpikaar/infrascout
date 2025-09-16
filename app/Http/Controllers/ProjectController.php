<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Contact;
use App\Models\Project;
use Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::orderBy('created_at', 'DESC')->paginate(15);
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $validated = $request->validated();

        // Resolve contact: prefer provided contact_id, else find-or-create by unique keys
        $contactId = $validated['contact_id'] ?? null;
        if (!$contactId) {
            $contact = Contact::query()
                ->where(function ($q) use ($validated) {
                    if (!empty($validated['mail'])) {
                        $q->orWhere('email', $validated['mail']);
                    }
                    if (!empty($validated['phone'])) {
                        $q->orWhere('phone', $validated['phone']);
                    }
                    if (!empty($validated['contact'])) {
                        $q->orWhere('name', $validated['contact']);
                    }
                })
                ->first();

            if (!$contact) {
                $contact = Contact::create([
                    'name'    => $validated['contact'] ?? 'Unknown',
                    'phone'   => $validated['phone'] ?? null,
                    'email'   => $validated['mail'] ?? null,
                    'address' => $validated['address'] ?? null,
                ]);
            } else {
                // Optionally update missing fields
                $contact->fill([
                    'name'    => $validated['contact'] ?? $contact->name,
                    'phone'   => $validated['phone'] ?? $contact->phone,
                    'email'   => $validated['mail'] ?? $contact->email,
                    'address' => $validated['address'] ?? $contact->address,
                ])->save();
            }

            $contactId = $contact->id;
        }

        // Prepare data for projects table only
        $projectData = [
            'number'     => $validated['number'],
            'name'       => $validated['name'],
            'client'     => $validated['client'],
            'contact_id' => $contactId,
        ];

        if ($request->hasFile('thumbnail')) {
            $thumb = $request->file('thumbnail')->store('images/projects', 'public');
            $projectData['thumbnail'] = str_replace('images/projects/', '', $thumb);
        }

        $project = Project::create($projectData);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Project created successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        // Load project with its reports
        $project->load(['reports', 'contact']);

        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $validated = $request->validated();

        // Resolve contact
        $contactId = $validated['contact_id'] ?? $project->contact_id ?? null;
        if (!$contactId) {
            $contact = Contact::query()
                ->where(function ($q) use ($validated) {
                    if (!empty($validated['mail'])) {
                        $q->orWhere('email', $validated['mail']);
                    }
                    if (!empty($validated['phone'])) {
                        $q->orWhere('phone', $validated['phone']);
                    }
                    if (!empty($validated['contact'])) {
                        $q->orWhere('name', $validated['contact']);
                    }
                })
                ->first();

            if (!$contact) {
                $contact = Contact::create([
                    'name'    => $validated['contact'] ?? 'Unknown',
                    'phone'   => $validated['phone'] ?? null,
                    'email'   => $validated['mail'] ?? null,
                    'address' => $validated['address'] ?? null,
                ]);
            } else {
                $contact->fill([
                    'name'    => $validated['contact'] ?? $contact->name,
                    'phone'   => $validated['phone'] ?? $contact->phone,
                    'email'   => $validated['mail'] ?? $contact->email,
                    'address' => $validated['address'] ?? $contact->address,
                ])->save();
            }

            $contactId = $contact->id;
        }

        $projectData = [
            'name'       => $validated['name'],
            'client'     => $validated['client'],
            'contact_id' => $contactId,
        ];

        if($request->hasFile('thumbnail')) {
            if($project->thumbnail) {
                Storage::disk('public')->delete('images/projects/'.$project->thumbnail);
            }
            $thumb = $request->file('thumbnail')->store('images/projects', 'public');
            $projectData['thumbnail'] = str_replace('images/projects/', '', $thumb);
        }

        $project->update($projectData);

        return redirect()->route('projects.show', $project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
