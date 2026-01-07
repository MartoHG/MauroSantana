<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Muestra la página principal [cite: 151]
    public function index()
    {
        return view('index'); // Esta es la vista index.blade.php que creamos antes
    }

    // Muestra el detalle de un proyecto [cite: 153]
    public function show($id)
    {
        // Por ahora, como no hay base de datos, solo devolvemos la vista
        return view('proyecto_detalle'); 
    }
}