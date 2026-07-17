<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Project;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Panel de control con métricas reales de la plataforma.
     */
    public function index()
    {
        $stats = [
            'proyectos' => Project::where('tipo', 'Proyecto')->count(),
            'ordenanzas' => Project::where('tipo', 'Ordenanza')->count(),
            'colaboradores' => User::where('role', UserRole::Colaborador->value)->count(),
            'administradores' => User::where('role', UserRole::Admin->value)->count(),
        ];

        $totalDocumentos = $stats['proyectos'] + $stats['ordenanzas'];

        $recientes = Project::latest()->take(5)->get();

        $ultimaCarga = $recientes->first()?->created_at;

        return view('dashboard', compact('stats', 'totalDocumentos', 'recientes', 'ultimaCarga'));
    }
}
