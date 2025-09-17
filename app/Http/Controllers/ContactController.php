<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Search contacts by name prefix, returns JSON for autocomplete.
     */
    public function search(Request $request)
    {
        $q = trim((string) $request->get('q', ''));

        if ($q === '') {
            return response()->json([]);
        }

        $contacts = Contact::query()
            ->where('name', 'like', $q . '%')
            ->orderBy('name')
            ->limit(8)
            ->get(['id', 'name', 'phone', 'email', 'address']);

        return response()->json($contacts);
    }
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        //
    }
}
