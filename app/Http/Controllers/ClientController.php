<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Contact;
use App\Models\Client;
use Storage;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::withCount('reports')->orderBy('created_at', 'DESC')->paginate(15);
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        $validated = $request->validated();

        // Resolve contact: prefer provided contact_id, else find-or-create by unique keys
        $contactId = $validated['contact_id'] ?? null;
        $contact = null;

        if ($contactId) {
            $contact = Contact::find($contactId);
        }

        if (!$contact) {
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
        }

        if (!$contact) {
            $contact = Contact::create([
                'name' => $validated['contact'] ?? 'Unknown',
                'phone' => $validated['phone'] ?? null,
                'email' => $validated['mail'] ?? null,
                'street' => $validated['street'] ?? null,
                'zipcode' => $validated['zipcode'] ?? null,
                'city' => $validated['city'] ?? null,
            ]);
        } else {
            // Update existing contact fields
            $contact->fill([
                'name' => $validated['contact'] ?? $contact->name,
                'phone' => $validated['phone'] ?? $contact->phone,
                'email' => $validated['mail'] ?? $contact->email,
                'street' => $validated['street'] ?? $contact->street,
                'zipcode' => $validated['zipcode'] ?? $contact->zipcode,
                'city' => $validated['city'] ?? $contact->city,
            ])->save();
        }

        $contactId = $contact->id;

        // Prepare data for clients table only
        $clientData = [
            'number' => uniqid(),
            'name' => $validated['name'],
            'contact_id' => $contactId,
        ];

        if ($request->hasFile('thumbnail')) {
            $thumb = $request->file('thumbnail')->store('images/clients', 'public');
            $clientData['thumbnail'] = str_replace('images/clients/', '', $thumb);
        }

        $client = Client::create($clientData);

        return redirect()->route('clients.show', $client)
            ->with('success', 'Client created successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        // Load client with its reports
        $client->load(['reports', 'contact']);

        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        $validated = $request->validated();

        // Resolve contact
        $contactId = $validated['contact_id'] ?? $client->contact_id ?? null;
        $contact = null;

        if ($contactId) {
            $contact = Contact::find($contactId);
        }

        if (!$contact) {
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
        }

        if (!$contact) {
            $contact = Contact::create([
                'name' => $validated['contact'] ?? 'Unknown',
                'phone' => $validated['phone'] ?? null,
                'email' => $validated['mail'] ?? null,
                'street' => $validated['street'] ?? null,
                'zipcode' => $validated['zipcode'] ?? null,
                'city' => $validated['city'] ?? null,
            ]);
        } else {
            $contact->fill([
                'name' => $validated['contact'] ?? $contact->name,
                'phone' => $validated['phone'] ?? $contact->phone,
                'email' => $validated['mail'] ?? $contact->email,
                'street' => $validated['street'] ?? $contact->street,
                'zipcode' => $validated['zipcode'] ?? $contact->zipcode,
                'city' => $validated['city'] ?? $contact->city,
            ])->save();
        }

        $contactId = $contact->id;

        $clientData = [
            'name' => $validated['name'],
            'contact_id' => $contactId,
        ];
        //        dd($clientData);
        if ($request->hasFile('thumbnail')) {
            if ($client->thumbnail) {
                Storage::disk('public')->delete('images/clients/' . $client->thumbnail);
            }
            $thumb = $request->file('thumbnail')->store('images/clients', 'public');
            $clientData['thumbnail'] = str_replace('images/clients/', '', $thumb);

        }

        $client->update($clientData);

        return redirect()->route('clients.show', $client);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //
    }
}
