<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
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
        
        $request->validate([
            'titulo' => [
                'required',
                Rule::unique('projects')->where(function ($query) use ($request) {
                    return $query->where('tipo', $request->tipo);
                }),
            ],
            'tipo' => 'required|in:Proyecto,Ordenanza',
            'categoria' => 'required',
            'fecha' => 'required|date',
            'pdf' => 'required|mimes:pdf|max:20480',
            'imagen' => 'nullable|image|max:10240',
            'descripcion' => 'nullable|string', 
        ], [
            'titulo.unique' => 'Ya existe un documento de tipo "' . $request->tipo . '" con este título exacto.'
        ]);

        // Control de Duplicados de PDF, La informacion del pdf se Hashea y gracias a ello se puede hacer un control de duplicados mas efectivo
        $uploadedFileHash = hash_file('sha256', $request->file('pdf')->getRealPath());
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

        // 5. Guardar (Ahora guardamos todo)
        Project::create([
            'titulo' => $request->titulo,
            'tipo' => $request->tipo,
            'categoria' => $request->categoria,
            'fecha' => $request->fecha,
            'descripcion' => $request->descripcion, // GUARDAMOS LA DESCRIPCIÓN
            'pdf_path' => $pdfPath,
            'pdf_hash' => $uploadedFileHash,
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
            'titulo' => [
                'required',
                'string',
                'max:255',
                Rule::unique('projects')->where(function ($query) use ($request) {
                    return $query->where('tipo', $request->tipo);
                })->ignore($project->id),
            ],
            'tipo' => 'required|in:Proyecto,Ordenanza', // VALIDAMOS TIPO AL EDITAR
            'fecha' => 'required|date',
            'categoria' => 'required|string',
            'descripcion' => 'nullable|string', // VALIDAMOS DESCRIPCIÓN
            'pdf' => 'nullable|mimes:pdf|max:20480',
            'imagen' => 'nullable|image|max:10240', // VALIDAMOS IMAGEN
        ], [
            'titulo.unique' => 'Ya existe otro documento de tipo "' . $request->tipo . '" con este título.'
        ]);

        // 1. Lógica Imagen (NUEVO: Ahora permite actualizar imagen)
        if ($request->hasFile('imagen')) {
            // Borrar vieja
            if ($project->imagen_path) Storage::disk('public')->delete($project->imagen_path);
            // Guardar nueva
            $project->imagen_path = $request->file('imagen')->store('project_images', 'public');
        }

        // 2. Lógica PDF (Solo si suben uno nuevo)
        if ($request->hasFile('pdf')) {
            // A. Chequeo de duplicados
            $newFileHash = hash_file('sha256', $request->file('pdf')->getRealPath());
            
            $duplicatePdf = Project::where('pdf_hash', $newFileHash)
                                    ->where('tipo', $request->tipo)
                                    ->where('id', '!=', $project->id)
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
            $project->pdf_hash = $newFileHash;

            // D. Regenerar QR
            $url = asset('storage/' . $pdfPath);
            $qrFileName = 'qrs/qr_' . time() . '.svg';
            
            $qrDirectory = storage_path('app/public/qrs');
            if (!file_exists($qrDirectory)) mkdir($qrDirectory, 0755, true);

            QrCode::format('svg')->size(300)->generate($url, storage_path('app/public/' . $qrFileName));
            $project->qr_path = $qrFileName;
        }

        // 3. Actualizar Textos (Incluyendo Tipo y Descripción)
        $project->update([
            'titulo' => $request->titulo,
            'tipo' => $request->tipo, // ACTUALIZAMOS TIPO
            'fecha' => $request->fecha,
            'categoria' => $request->categoria,
            'descripcion' => $request->descripcion, // ACTUALIZAMOS DESCRIPCIÓN
            // imagen_path y pdf_path ya se actualizaron arriba si fue necesario
        ]);
        
        // Guardar explícitamente para asegurar cambios en paths
        $project->save();

        return redirect()->route('projects.index')->with('success', 'Proyecto actualizado correctamente.');
    }

    public function destroy($id)
    {
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
        $query = Project::query();

        if ($request->filled('search')) {
            $query->where('titulo', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }
        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        switch ($request->get('orden', 'fecha_desc')) {
            case 'alpha_asc':
                $query->orderBy('titulo', 'asc');
                break;
            case 'alpha_desc':
                $query->orderBy('titulo', 'desc');
                break;
            case 'cat_asc':
                $query->orderBy('categoria', 'asc');
                break;
            case 'fecha_asc':
                $query->orderBy('fecha', 'asc');
                break;
            default:
                $query->orderBy('fecha', 'desc');
        }
        $projects = $query->paginate(9)->withQueryString();

        return view('projects.public_index', compact('projects'));
    }
}

