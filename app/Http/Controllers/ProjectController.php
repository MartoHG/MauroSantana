<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProjectController extends Controller
{
    /**
     * Muestra la lista de proyectos.
     */
    public function index()
    {
        $projects = Project::orderBy('fecha', 'desc')->get();
        return view('projects.index', compact('projects'));
    }

    /**
     * Muestra el formulario de creación.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Guarda el proyecto y GENERA EL QR.
     */
    public function store(Request $request)
    {
        // 1. Validación
        $request->validate([
            'titulo' => 'required',
            'tipo' => 'required|in:Proyecto,Ordenanza',
            'categoria' => 'required',
            'fecha' => 'required|date',
            'pdf' => 'required|mimes:pdf|max:20480', // Máx 20MB
            'imagen' => 'nullable|image|max:10240', // Opcional, Máx 10MB
        ]);

        // 2. Subida de Archivos
        
        // A. Subir PDF
        $pdfPath = $request->file('pdf')->store('pdfs', 'public');

        // B. Subir Imagen (Solo si existe)
        $imagenPath = null;
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('project_images', 'public');
        }

        // 3. Generar QR (Apunta al PDF)
        $url = asset('storage/' . $pdfPath);
        $qrFileName = 'qrs/qr_' . time() . '.svg';

        // --- SOLUCIÓN AL ERROR DE CARPETA ---
        // Verificamos si la carpeta existe, si no, la creamos.
        $qrDirectory = storage_path('app/public/qrs');
        if (!file_exists($qrDirectory)) {
            mkdir($qrDirectory, 0755, true);
        }
        // ------------------------------------

        // Generamos el QR
        QrCode::format('svg')->size(300)->generate($url, storage_path('app/public/' . $qrFileName));

        // 4. Guardar en Base de Datos
        Project::create([
            'titulo' => $request->titulo,
            'tipo' => $request->tipo,
            'categoria' => $request->categoria,
            'fecha' => $request->fecha,
            'pdf_path' => $pdfPath,
            'imagen_path' => $imagenPath,
            'qr_path' => $qrFileName,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('projects.index')->with('success', 'Proyecto creado con éxito.');
    }

    /**
     * Muestra el formulario de edición.
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        return view('projects.edit', compact('project'));
    }

    /**
     * Actualiza el proyecto.
     */
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        // Validación (PDF e Imagen son opcionales en update)
        $request->validate([
            'titulo' => 'required|string|max:255',
            'tipo' => 'required|in:Proyecto,Ordenanza',
            'fecha' => 'required|date',
            'categoria' => 'required|string',
            'pdf' => 'nullable|mimes:pdf|max:20480',
            'imagen' => 'nullable|image|max:10240',
        ]);

        // 1. Lógica para IMAGEN
        if ($request->hasFile('imagen')) {
            // Borrar imagen vieja si existe
            if ($project->imagen_path) {
                Storage::disk('public')->delete($project->imagen_path);
            }
            // Guardar nueva
            $project->imagen_path = $request->file('imagen')->store('project_images', 'public');
        }

        // 2. Lógica para PDF y QR (Solo si suben un PDF nuevo)
        if ($request->hasFile('pdf')) {
            // Borrar PDF viejo
            if ($project->pdf_path) Storage::disk('public')->delete($project->pdf_path);
            // Borrar QR viejo
            if ($project->qr_path) Storage::disk('public')->delete($project->qr_path);

            // Subir nuevo PDF
            $pdfPath = $request->file('pdf')->store('pdfs', 'public');
            $project->pdf_path = $pdfPath;

            // Regenerar QR
            $url = asset('storage/' . $pdfPath);
            $qrFileName = 'qrs/qr_' . time() . '.svg';

            // Verificar carpeta QRS también en update por seguridad
            $qrDirectory = storage_path('app/public/qrs');
            if (!file_exists($qrDirectory)) {
                mkdir($qrDirectory, 0755, true);
            }

            QrCode::format('svg')->size(300)->generate($url, storage_path('app/public/' . $qrFileName));
            $project->qr_path = $qrFileName;
        }

        // 3. Actualizar datos de texto
        $project->update([
            'titulo' => $request->titulo,
            'tipo' => $request->tipo,
            'fecha' => $request->fecha,
            'categoria' => $request->categoria,
            // nota: imagen_path y pdf_path/qr_path ya se actualizaron arriba si fue necesario
        ]);
        
        // Guardar explícitamente para asegurar cambios en paths
        $project->save();

        return redirect()->route('projects.index')->with('success', 'Proyecto actualizado correctamente.');
    }

    /**
     * Elimina el proyecto, el PDF, la Imagen y el QR.
     */
    public function destroy($id)
    {
        // SEGURIDAD: Verificar Roles
        $rol = auth()->user()->role;
        $rolesPermitidos = ['Admin', 'admin', 'Administrador', 'Colaborador', 'colaborador'];

        if (!in_array($rol, $rolesPermitidos)) {
            abort(403, 'No tienes permiso para eliminar proyectos.');
        }

        $project = Project::findOrFail($id);

        // 1. Borrar PDF
        if ($project->pdf_path) {
            Storage::disk('public')->delete($project->pdf_path);
        }

        // 2. Borrar QR
        if ($project->qr_path) {
            Storage::disk('public')->delete($project->qr_path);
        }

        // 3. Borrar Imagen de Portada (Nuevo)
        if ($project->imagen_path) {
            Storage::disk('public')->delete($project->imagen_path);
        }

        // 4. Borrar Registro de Base de Datos
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Proyecto eliminado correctamente.');
    }
}