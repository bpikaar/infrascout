<?php

namespace App\Http\Controllers;

use App\Models\MethodDescription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MethodDescriptionController extends Controller
{
    /**
     * Display a listing of the method descriptions.
     */
    public function index(): View
    {
        $descriptions = MethodDescription::orderBy('method_name')->get();

        return view('method-descriptions.index', [
            'descriptions' => $descriptions,
        ]);
    }

    /**
     * Show the form for editing the specified method description.
     */
    public function edit(MethodDescription $methodDescription): View
    {
        return view('method-descriptions.edit', [
            'description' => $methodDescription,
        ]);
    }

    /**
     * Update the specified method description in storage.
     */
    public function update(Request $request, MethodDescription $methodDescription): RedirectResponse
    {
        $validated = $request->validate([
            'method_name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $methodDescription->update($validated);

        return redirect()->route('method-descriptions.index')
            ->with('status', 'description-updated');
    }
}

