<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(private readonly ProjectService $projects) {}

    public function index()
    {
        $this->authorize('viewAny', Project::class);

        $projects = Project::orderBy('fecha', 'desc')->get();

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $this->authorize('create', Project::class);

        return view('projects.create');
    }

    public function store(StoreProjectRequest $request)
    {
        $this->projects->create(
            $request->safe()->except(['pdf', 'imagen']),
            $request->file('pdf'),
            $request->file('imagen'),
            $request->user(),
        );

        return redirect()->route('projects.index')->with('success', 'Proyecto creado con éxito.');
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.edit', compact('project'));
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $this->projects->update(
            $project,
            $request->safe()->except(['pdf', 'imagen']),
            $request->file('pdf'),
            $request->file('imagen'),
        );

        return redirect()->route('projects.index')->with('success', 'Proyecto actualizado correctamente.');
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        $this->projects->delete($project);

        return redirect()->route('projects.index')->with('success', 'Proyecto eliminado correctamente.');
    }

    /**
     * Buscador público avanzado de proyectos y ordenanzas.
     */
    public function publicIndex(Request $request)
    {
        $query = Project::query();

        if ($request->filled('search')) {
            $query->where('titulo', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        match ($request->get('orden', 'fecha_desc')) {
            'alpha_asc' => $query->orderBy('titulo', 'asc'),
            'alpha_desc' => $query->orderBy('titulo', 'desc'),
            'cat_asc' => $query->orderBy('categoria', 'asc'),
            'fecha_asc' => $query->orderBy('fecha', 'asc'),
            default => $query->orderBy('fecha', 'desc'),
        };

        $projects = $query->paginate(9)->withQueryString();

        return view('projects.public_index', compact('projects'));
    }
}
