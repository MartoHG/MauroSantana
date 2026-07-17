<?php

namespace App\Http\Controllers;

use App\Models\Project;

class HomeController extends Controller
{
    /**
     * Página principal pública con los proyectos más recientes.
     */
    public function index()
    {
        $projects = Project::orderBy('fecha', 'desc')->get();

        return view('welcome', compact('projects'));
    }
}
