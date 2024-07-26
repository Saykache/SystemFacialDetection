<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        
        // Remover caracteres não numéricos do campo cpf_cnpj
        $request->merge([
            'cpf_cnpj' => preg_replace('/\D/', '', $request->input('cpf_cnpj'))
        ]);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'tipo_pessoa' => ['required', 'string' ,'max:1'],
            'cpf_cnpj' => ['required', 'string', 'max:14', 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'tipo_pessoa' => $request->tipo_pessoa,
            'cpf_cnpj' => $request->cpf_cnpj,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
