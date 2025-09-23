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
        $query = Report::with(['project', 'pdf'])->latest();

        if (request('all')) {
            $reports = $query->paginate(10)->appends(['all' => 1]);
        } else {
            $reports = $query->take(5)->get();
        }

        return view('dashboard', compact('reports'));
    }
}
