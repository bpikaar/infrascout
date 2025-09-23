<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        return redirect()->route('projects.index');
    }

    public function dashboard() {
        $reports = Report::with(['project', 'pdf'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('reports'));
    }
}
