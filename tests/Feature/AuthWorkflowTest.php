<?php

namespace Tests\Feature;

use App\Models\Board;
use App\Models\Universe;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthWorkflowTest extends TestCase
{
    public function test_login_and_register_pages_load_successfully(): void
    {
        $loginRes = $this->get(route('login'));
        $loginRes->assertOk()
            ->assertSee('Bienvenido de vuelta')
            ->assertSee('Entrar a Estudio Cóice');

        $registerRes = $this->get(route('register'));
        $registerRes->assertOk()
            ->assertSee('Empieza a construir tus universos')
            ->assertSee('Crear mi Estudio Cóice');
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $uniqueEmail = 'test_user_'.Str::random(6).'@example.com';
        $user = User::query()->create([
            'name' => 'Tester Creative',
            'email' => $uniqueEmail,
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post(route('login.post'), [
            'email' => $uniqueEmail,
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('studio.canvas'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_invalid_password(): void
    {
        $uniqueEmail = 'test_fail_'.Str::random(6).'@example.com';
        User::query()->create([
            'name' => 'Fail User',
            'email' => $uniqueEmail,
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post(route('login.post'), [
            'email' => $uniqueEmail,
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_user_can_register_and_workspace_is_auto_provisioned(): void
    {
        $uniqueEmail = 'new_creator_'.Str::random(6).'@example.com';

        $response = $this->post(route('register.post'), [
            'name' => 'Elena Vance',
            'email' => $uniqueEmail,
            'password' => 'SecurePass123!',
            'password_confirmation' => 'SecurePass123!',
            'creative_role' => 'Guionista / Arquitecto Narrativo',
            'terms' => true,
        ]);

        $response->assertRedirect(route('studio.canvas'));
        $this->assertAuthenticated();

        $user = User::query()->where('email', $uniqueEmail)->first();
        $this->assertNotNull($user);

        // Verify dedicated universe was provisioned
        $universe = Universe::query()->where('user_id', $user->id)->first();
        $this->assertNotNull($universe);
        $this->assertStringContainsString('Elena Vance', $universe->title);

        // Verify initial board and welcome node
        $board = Board::query()->where('universe_id', $universe->id)->first();
        $this->assertNotNull($board);
        $this->assertGreaterThanOrEqual(1, $board->nodes()->count());
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::query()->first() ?? User::query()->create([
            'name' => 'Logout User',
            'email' => 'logout_'.Str::random(6).'@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->actingAs($user)->post(route('logout'));
        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }
}
