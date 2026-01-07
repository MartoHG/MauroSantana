<?php

namespace App\Http\Controllers;

use App\Models\User; // <--- FALTABA ESTA LÍNEA IMPORTANTE
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
// Lista de versiones aceptadas de "Administrador"
    $admins = ['Admin', 'admin', 'Administrador'];

    if (!in_array(auth()->user()->role, $admins)) {
        abort(403, 'Acceso denegado. Solo administradores.');
    }
    
    $users = User::all();
    return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
// Lista de versiones aceptadas de "Administrador"
    $admins = ['Admin', 'admin', 'Administrador'];

    if (!in_array(auth()->user()->role, $admins)) {
        abort(403, 'Acceso denegado. Solo administradores.');
    }
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
// Lista de versiones aceptadas de "Administrador"
    $admins = ['Admin', 'admin', 'Administrador'];

    if (!in_array(auth()->user()->role, $admins)) {
        abort(403, 'Acceso denegado. Solo administradores.');
    }
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,colaborador'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
// Función para mostrar el formulario (EDIT)
public function edit($id)
{
// Lista de versiones aceptadas de "Administrador"
    $admins = ['Admin', 'admin', 'Administrador'];

    if (!in_array(auth()->user()->role, $admins)) {
        abort(403, 'Acceso denegado. Solo administradores.');
    }
    $user = User::findOrFail($id);
    return view('users.edit', compact('user'));
}

// Función para guardar los cambios (UPDATE)
public function update(Request $request, $id)
{
// Lista de versiones aceptadas de "Administrador"
    $admins = ['Admin', 'admin', 'Administrador'];

    if (!in_array(auth()->user()->role, $admins)) {
        abort(403, 'Acceso denegado. Solo administradores.');
    }
    $user = User::findOrFail($id);

    // 1. Validación
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,'.$user->id,
        'role' => 'required',
        // 'nullable' permite que esté vacío. 'confirmed' exige que coincida con password_confirmation
        'password' => 'nullable|min:8|confirmed', 
    ]);

    // 2. Preparar los datos básicos
    $data = [
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
    ];

    // 3. Lógica de la contraseña: Solo si el campo NO está vacío, la hasheamos y actualizamos
    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    // 4. Actualizar usuario
    $user->update($data);

    return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
}

    /**
     * Remove the specified resource from storage.
     */
public function destroy($id)
{
    // 1. SEGURIDAD: Solo Admins pueden borrar
    // Aceptamos variantes de mayúsculas/minúsculas
    $admins = ['Admin', 'admin', 'Administrador'];
    
    if (!in_array(auth()->user()->role, $admins)) {
        abort(403, 'No tienes permiso para eliminar usuarios.');
    }

    // 2. Buscar al usuario
    $user = User::findOrFail($id);

    // 3. PREVENCIÓN: No permitir borrarse a uno mismo
    // Esto evita que te quedes fuera del sistema por error
    if (auth()->id() == $user->id) {
        return redirect()->route('users.index')
            ->with('error', 'No puedes eliminar tu propia cuenta mientras estás conectado.');
    }

    try {
        // 4. Intentar eliminar
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuario eliminado correctamente.');

    } catch (\Illuminate\Database\QueryException $e) {
        // 5. MANEJO DE ERROR (Clave para evitar pantalla blanca)
        // Esto pasa si el usuario tiene proyectos creados y la base de datos protege la relación
        
        return redirect()->route('users.index')
            ->with('error', 'No se puede eliminar este usuario porque tiene proyectos o datos asociados. Elimina sus proyectos primero.');
    }
}
}