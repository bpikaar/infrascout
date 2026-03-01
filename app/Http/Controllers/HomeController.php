<?php

namespace App\Http\Controllers;

use App\Models\Report;

class HomeController extends Controller
{
    public function index() {
        return redirect()->route('clients.index');
    }

    public function dashboard() {
        $query = Report::with(['client', 'pdf'])->latest();

        if (request('all')) {
            $reports = $query->paginate(10)->appends(['all' => 1]);
        } else {
            $reports = $query->take(5)->get();
        }

        return view('dashboard', compact('reports'));
    }
}
