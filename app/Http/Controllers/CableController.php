<?php

namespace App\Http\Controllers;

use App\Models\Cable;
use Illuminate\Http\Request;

class CableController extends Controller
{
    public function search(Request $request)
    {
        $q = trim($request->get('q', ''));

        $query = Cable::query();
        if($q !== '') {
            $query->where('cable_type', 'like', "%{$q}%");
        }

        $results = $query->orderBy('cable_type')
            ->limit(30)
            ->get(['id','cable_type','material','diameter']);

        return response()->json($results);
    }
}
