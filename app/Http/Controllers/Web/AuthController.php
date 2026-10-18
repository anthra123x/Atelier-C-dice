<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Board;
use App\Models\CanvasNode;
use App\Models\Collaborator;
use App\Models\Universe;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Show the Estudio Cóice login form.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('studio.canvas');
        }

        return view('auth.login');
    }

    /**
     * Handle user login.
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        $remember = (bool) $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->route('studio.canvas')->with('success', '¡Bienvenido de vuelta a tu Estudio Cóice!');
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->withInput($request->only('email'));
    }

    /**
     * Show the Estudio Cóice register form.
     */
    public function showRegisterForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('studio.canvas');
        }

        return view('auth.register');
    }

    /**
     * Handle user registration.
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = User::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Auto-provision initial workspace for the new creator
        $slug = Str::slug($user->name).'-estudio-'.Str::random(5);
        $universe = Universe::query()->create([
            'user_id' => $user->id,
            'title' => 'Universo de '.$user->name,
            'slug' => $slug,
            'tagline' => 'Compendio creativo personal y cartografía narrativa.',
            'description' => 'Espacio de trabajo y worldbuilding inicial.',
            'settings' => [
                'theme' => 'Estudio Cóice',
                'creative_role' => $validated['creative_role'] ?? 'Autor / Diseñador',
            ],
        ]);

        // Provision initial Board
        $board = Board::query()->create([
            'universe_id' => $universe->id,
            'title' => 'Tablero Principal',
            'slug' => 'tablero-principal',
            'act' => 'Acto I: Génesis',
            'is_active' => true,
            'grid_snap_size' => 24,
            'zoom_level' => 100,
        ]);

        // Welcome note node
        CanvasNode::query()->create([
            'board_id' => $board->id,
            'type' => 'note',
            'title' => '¡Bienvenido a tu Estudio Cóice!',
            'pos_x' => 120,
            'pos_y' => 100,
            'width' => 360,
            'data' => [
                'category' => 'Inicio',
                'body' => 'Este es tu lienzo creativo infinito. Puedes añadir notas, personajes, locaciones y conexiones vectoriales. El Asistente Cóice AI está listo para ayudarte a crear.',
                'tags' => ['Estudio', 'Bienvenida'],
            ],
        ]);

        // Add creator as primary collaborator
        Collaborator::query()->create([
            'universe_id' => $universe->id,
            'name' => $user->name,
            'initials' => strtoupper(substr($user->name, 0, 2)),
            'role' => 'Autor Principal',
            'color' => '#4F46E5',
            'is_online' => true,
        ]);

        Auth::login($user, true);
        $request->session()->regenerate();

        return redirect()->route('studio.canvas')->with('success', '¡Tu Estudio Cóice ha sido creado exitosamente!');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('info', 'Has cerrado sesión.');
    }
}
