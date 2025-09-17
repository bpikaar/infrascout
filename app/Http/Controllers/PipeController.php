<?php

namespace App\Http\Controllers;

use App\Models\Pipe;
use Illuminate\Http\Request;

class PipeController extends Controller
{
    public function search(Request $request)
    {
        $q = trim($request->get('q', ''));

        $query = Pipe::query();
        if($q !== '') {
            $query->where('pipe_type', 'like', "%{$q}%");
        }

        $results = $query->orderBy('pipe_type')
            ->limit(30)
            ->get(['id','pipe_type','material','diameter']);

        return response()->json($results);
    }
}
