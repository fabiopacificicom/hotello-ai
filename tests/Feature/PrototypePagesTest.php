<?php

use App\Models\User;

test('the public landing page displays the prototype and manager login link', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('Villa Esmeralda')
        ->assertSee('Manager Login')
        ->assertSee('No real bookings or availability checks.');
});

test('the manager dashboard requires authentication', function () {
    $this->get('/dashboard')->assertRedirect(route('login'));
});

test('an authenticated user sees the manager prototype and logout form', function () {
    $this->actingAs(User::factory()->create())
        ->get('/dashboard')
        ->assertOk()
        ->assertSee('Manager Panel')
        ->assertSee('Sample data; no real actions.')
        ->assertSee('Logout');
});

test('registration leads to the protected manager page and logout ends access', function () {
    $this->post('/register', [
        'name' => 'Manager',
        'email' => 'manager@example.test',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertRedirect(route('dashboard', absolute: false));

    $this->get('/dashboard')->assertOk();
    $this->post('/logout')->assertRedirect('/');
    $this->get('/dashboard')->assertRedirect(route('login'));
});
