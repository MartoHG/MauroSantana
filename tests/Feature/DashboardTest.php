<?php

use App\Models\Project;
use App\Models\User;

it('muestra el panel con las métricas correctas', function () {
    $admin = User::factory()->admin()->create();
    Project::factory()->count(3)->create(['tipo' => 'Proyecto']);
    Project::factory()->count(2)->create(['tipo' => 'Ordenanza']);

    $this->actingAs($admin)->get(route('dashboard'))
        ->assertOk()
        ->assertViewHas('totalDocumentos', 5)
        ->assertViewHas('stats', fn (array $stats) => $stats['proyectos'] === 3 && $stats['ordenanzas'] === 2);
});

it('redirige al login a un invitado que entra al panel', function () {
    $this->get(route('dashboard'))->assertRedirect(route('login'));
});
