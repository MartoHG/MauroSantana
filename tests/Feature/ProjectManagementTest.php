<?php

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('exige autenticación para cargar proyectos', function () {
    $this->post(route('projects.store'), [])->assertRedirect(route('login'));
});

it('permite a un colaborador cargar un documento y le genera el QR', function () {
    Storage::fake('public');
    $colaborador = User::factory()->colaborador()->create();

    $this->actingAs($colaborador)->post(route('projects.store'), [
        'titulo' => 'Plan de veredas inclusivas',
        'tipo' => 'Proyecto',
        'categoria' => 'Obras Públicas',
        'fecha' => '2026-05-01',
        'descripcion' => 'Descripción de prueba',
        'pdf' => UploadedFile::fake()->create('documento.pdf', 120, 'application/pdf'),
    ])->assertRedirect(route('projects.index'));

    $project = Project::first();
    expect($project)->not->toBeNull()
        ->and($project->user_id)->toBe($colaborador->id)
        ->and($project->pdf_hash)->not->toBeNull();

    Storage::disk('public')->assertExists($project->pdf_path);
    Storage::disk('public')->assertExists($project->qr_path);
});

it('rechaza subir dos veces el mismo PDF dentro del mismo tipo', function () {
    Storage::fake('public');
    $colaborador = User::factory()->colaborador()->create();

    $payload = fn (string $titulo) => [
        'titulo' => $titulo,
        'tipo' => 'Proyecto',
        'categoria' => 'Salud',
        'fecha' => '2026-05-01',
        'pdf' => UploadedFile::fake()->create('documento.pdf', 120, 'application/pdf'),
    ];

    $this->actingAs($colaborador)
        ->post(route('projects.store'), $payload('Primer documento'))
        ->assertRedirect(route('projects.index'));

    $this->actingAs($colaborador)
        ->from(route('projects.create'))
        ->post(route('projects.store'), $payload('Segundo documento'))
        ->assertRedirect(route('projects.create'))
        ->assertSessionHasErrors('pdf');

    expect(Project::count())->toBe(1);
});

it('permite a un administrador eliminar un proyecto y sus archivos', function () {
    Storage::fake('public');
    $admin = User::factory()->admin()->create();

    Storage::disk('public')->put('pdfs/doc.pdf', 'contenido');
    Storage::disk('public')->put('qrs/doc.svg', '<svg></svg>');

    $project = Project::factory()->create([
        'pdf_path' => 'pdfs/doc.pdf',
        'qr_path' => 'qrs/doc.svg',
        'imagen_path' => null,
    ]);

    $this->actingAs($admin)->delete(route('projects.destroy', $project))
        ->assertRedirect(route('projects.index'));

    $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    Storage::disk('public')->assertMissing('pdfs/doc.pdf');
    Storage::disk('public')->assertMissing('qrs/doc.svg');
});
