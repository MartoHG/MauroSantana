<?php

use App\Models\User;

it('permite a un administrador ver el listado de usuarios', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)->get(route('users.index'))->assertOk();
});

it('bloquea a un colaborador el acceso a la gestión de usuarios', function () {
    $colaborador = User::factory()->colaborador()->create();

    $this->actingAs($colaborador)->get(route('users.index'))->assertForbidden();
});

it('impide crear usuarios a quien no es administrador', function () {
    $colaborador = User::factory()->colaborador()->create();

    $this->actingAs($colaborador)->post(route('users.store'), [
        'name' => 'Intruso',
        'email' => 'intruso@test.com',
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
        'role' => 'admin',
    ])->assertForbidden();

    $this->assertDatabaseMissing('users', ['email' => 'intruso@test.com']);
});

it('permite a un administrador crear un usuario', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)->post(route('users.store'), [
        'name' => 'Nueva Colaboradora',
        'email' => 'nueva@test.com',
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
        'role' => 'colaborador',
    ])->assertRedirect(route('users.index'));

    $this->assertDatabaseHas('users', [
        'email' => 'nueva@test.com',
        'role' => 'colaborador',
    ]);
});

it('impide que un administrador se elimine a sí mismo', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)->delete(route('users.destroy', $admin))
        ->assertRedirect(route('users.index'))
        ->assertSessionHas('error');

    $this->assertDatabaseHas('users', ['id' => $admin->id]);
});

it('permite a un administrador eliminar a otro usuario', function () {
    $admin = User::factory()->admin()->create();
    $objetivo = User::factory()->colaborador()->create();

    $this->actingAs($admin)->delete(route('users.destroy', $objetivo))
        ->assertRedirect(route('users.index'));

    $this->assertDatabaseMissing('users', ['id' => $objetivo->id]);
});
