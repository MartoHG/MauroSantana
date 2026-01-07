<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    // Estos son los campos que permitimos guardar desde el formulario
protected $fillable = [
    'titulo',
    'tipo',          
    'descripcion',
    'fecha',
    'categoria',
    'estado',
    'pdf_path',
    'qr_path',
    'imagen_path',   
    'user_id',
];

    // Relación: Un proyecto pertenece a un usuario (el admin)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}