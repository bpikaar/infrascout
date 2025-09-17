<?php

namespace App\Http\Controllers;

use App\Models\Cable;
use Illuminate\Http\Request;

class CableController extends Controller
{
    public function search(Request $request)
    {
        $q = trim($request->get('q', ''));
        if(strlen($q) < 2) {
            return response()->json([]);
        }

        $results = Cable::query()
            ->where('cable_type', 'like', "%{$q}%")
            ->orderBy('cable_type')
            ->limit(15)
            ->get(['id','cable_type','material','diameter']);

        return response()->json($results);
    }
}
