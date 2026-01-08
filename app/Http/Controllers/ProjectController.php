<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule; // Importante para validar duplicados
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('fecha', 'desc')->get();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        // 1. Validaciones Básicas
        $request->validate([
            'tipo' => 'required|in:Proyecto,Ordenanza',
            'categoria' => 'required',
            'fecha' => 'required|date',
            'pdf' => 'required|mimes:pdf|max:20480',
            'imagen' => 'nullable|image|max:10240',
            
            // VALIDACIÓN DE TÍTULO DUPLICADO (Por Tipo)
            'titulo' => [
                'required',
                Rule::unique('projects')->where(function ($query) use ($request) {
                    return $query->where('tipo', $request->tipo);
                }),
            ],
        ], [
            'titulo.unique' => 'Ya existe un documento de tipo "' . $request->tipo . '" con este título exacto.'
        ]);

        // 2. CONTROL DE DUPLICADOS DE PDF (Por contenido/hash)
        // Calculamos la huella digital del archivo subido (SHA-256)
        $uploadedFileHash = hash_file('sha256', $request->file('pdf')->getRealPath());

        // Buscamos si ya existe ese hash para el mismo TIPO de documento
        $duplicatePdf = Project::where('pdf_hash', $uploadedFileHash)
                                ->where('tipo', $request->tipo)
                                ->first();

        if ($duplicatePdf) {
            return back()->withInput()->withErrors([
                'pdf' => 'Este archivo PDF ya fue subido anteriormente en el proyecto: "' . $duplicatePdf->titulo . '".'
            ]);
        }

        // 3. Subida de Archivos
        $pdfPath = $request->file('pdf')->store('pdfs', 'public');

        $imagenPath = null;
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('project_images', 'public');
        }

        // 4. Generar QR
        $url = asset('storage/' . $pdfPath);
        $qrFileName = 'qrs/qr_' . time() . '.svg';
        
        $qrDirectory = storage_path('app/public/qrs');
        if (!file_exists($qrDirectory)) mkdir($qrDirectory, 0755, true);

        QrCode::format('svg')->size(300)->generate($url, storage_path('app/public/' . $qrFileName));

        // 5. Guardar (Incluyendo el hash)
        Project::create([
            'titulo' => $request->titulo,
            'tipo' => $request->tipo,
            'categoria' => $request->categoria,
            'fecha' => $request->fecha,
            'pdf_path' => $pdfPath,
            'pdf_hash' => $uploadedFileHash, // Guardamos el hash
            'imagen_path' => $imagenPath,
            'qr_path' => $qrFileName,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('projects.index')->with('success', 'Proyecto creado con éxito.');
    }

    public function edit($id)
    {
        $project = Project::findOrFail($id);
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $request->validate([
            'tipo' => 'required|in:Proyecto,Ordenanza',
            'fecha' => 'required|date',
            'categoria' => 'required|string',
            'pdf' => 'nullable|mimes:pdf|max:20480',
            'imagen' => 'nullable|image|max:10240',
            
            // VALIDACIÓN TÍTULO (Ignorando el proyecto actual para que no de error al guardar lo mismo)
            'titulo' => [
                'required',
                'string',
                'max:255',
                Rule::unique('projects')->where(function ($query) use ($request) {
                    return $query->where('tipo', $request->tipo);
                })->ignore($project->id),
            ],
        ], [
            'titulo.unique' => 'Ya existe otro documento de tipo "' . $request->tipo . '" con este título.'
        ]);

        // 1. Lógica Imagen
        if ($request->hasFile('imagen')) {
            if ($project->imagen_path) Storage::disk('public')->delete($project->imagen_path);
            $project->imagen_path = $request->file('imagen')->store('project_images', 'public');
        }

        // 2. Lógica PDF (Solo si suben uno nuevo)
        if ($request->hasFile('pdf')) {
            
            // A. Chequeo de duplicados (Hash) ignorando el actual
            $newFileHash = hash_file('sha256', $request->file('pdf')->getRealPath());
            
            $duplicatePdf = Project::where('pdf_hash', $newFileHash)
                                    ->where('tipo', $request->tipo)
                                    ->where('id', '!=', $project->id) // Importante: ignorar este mismo proyecto
                                    ->first();

            if ($duplicatePdf) {
                return back()->withInput()->withErrors([
                    'pdf' => 'Este archivo PDF ya existe en otro proyecto: "' . $duplicatePdf->titulo . '".'
                ]);
            }

            // B. Borrar viejos
            if ($project->pdf_path) Storage::disk('public')->delete($project->pdf_path);
            if ($project->qr_path) Storage::disk('public')->delete($project->qr_path);

            // C. Subir nuevos
            $pdfPath = $request->file('pdf')->store('pdfs', 'public');
            $project->pdf_path = $pdfPath;
            $project->pdf_hash = $newFileHash; // Actualizar hash

            // D. Regenerar QR
            $url = asset('storage/' . $pdfPath);
            $qrFileName = 'qrs/qr_' . time() . '.svg';
            
            $qrDirectory = storage_path('app/public/qrs');
            if (!file_exists($qrDirectory)) mkdir($qrDirectory, 0755, true);

            QrCode::format('svg')->size(300)->generate($url, storage_path('app/public/' . $qrFileName));
            $project->qr_path = $qrFileName;
        }

        // 3. Actualizar Textos
        $project->update([
            'titulo' => $request->titulo,
            'tipo' => $request->tipo,
            'fecha' => $request->fecha,
            'categoria' => $request->categoria,
        ]);
        
        $project->save();

        return redirect()->route('projects.index')->with('success', 'Proyecto actualizado correctamente.');
    }

    public function destroy($id)
    {
        // ... (Tu código de destroy se mantiene igual) ...
        $rol = auth()->user()->role;
        $rolesPermitidos = ['Admin', 'admin', 'Administrador', 'Colaborador', 'colaborador'];

        if (!in_array($rol, $rolesPermitidos)) {
            abort(403, 'No tienes permiso para eliminar proyectos.');
        }

        $project = Project::findOrFail($id);

        if ($project->pdf_path) Storage::disk('public')->delete($project->pdf_path);
        if ($project->qr_path) Storage::disk('public')->delete($project->qr_path);
        if ($project->imagen_path) Storage::disk('public')->delete($project->imagen_path);

        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Proyecto eliminado correctamente.');
    }

    /**
     * Buscador Público Avanzado
     */
    public function publicIndex(Request $request)
    {
        // 1. Iniciamos la consulta base
        $query = Project::query();

        // 2. Filtro por Buscador (Título)
        if ($request->filled('search')) {
            $query->where('titulo', 'like', '%' . $request->search . '%');
        }

        // 3. Filtro por Tipo (Proyecto / Ordenanza)
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        // 4. Filtro por Categoría
        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        // 5. Ordenamiento
        switch ($request->get('orden', 'fecha_desc')) { // 'fecha_desc' es el default
            case 'alpha_asc':
                $query->orderBy('titulo', 'asc'); // A-Z
                break;
            case 'alpha_desc':
                $query->orderBy('titulo', 'desc'); // Z-A
                break;
            case 'cat_asc':
                $query->orderBy('categoria', 'asc'); // Por Categoría
                break;
            case 'fecha_asc':
                $query->orderBy('fecha', 'asc'); // Más viejos primero
                break;
            default: // fecha_desc
                $query->orderBy('fecha', 'desc'); // Más nuevos primero
        }

        // 6. Paginación (Mostramos 9 por página)
        // append($request->query()) mantiene los filtros al cambiar de página
        $projects = $query->paginate(9)->withQueryString();

        return view('projects.public_index', compact('projects'));
    }
}

