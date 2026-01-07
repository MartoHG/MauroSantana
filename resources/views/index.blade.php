@extends('layouts.public')

@section('content')
    <section id="institucional" class="hero-section text-center">
        <div class="container">
            <h1>Mauro Santana</h1>
            <p class="lead">Concejal de nuestra ciudad. Compromiso y Transparencia Legislativa.</p>
            <p>Aquí encontrarás todas mis iniciativas y proyectos presentados para mejorar nuestra comunidad.</p>
        </div>
    </section>

    <section id="proyectos" class="container mt-5">
        <h2 class="mb-4 text-center">Proyectos Legislativos</h2>
        
        <div class="row">
            <div class="col-md-4 project-card">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Título del Proyecto</h5>
                        <p class="card-text text-muted">Categoría | Fecha: 01/01/2024</p>
                        <p class="card-text">Breve descripción del proyecto para que la ciudadanía lo conozca.</p>
                        <a href="#" class="btn btn-outline-primary btn-sm">Ver Proyecto</a>
                        <a href="#" class="btn btn-primary btn-sm">Descargar PDF</a>
                    </div>
                </div>
            </div>
            </div>
    </section>
@endsection