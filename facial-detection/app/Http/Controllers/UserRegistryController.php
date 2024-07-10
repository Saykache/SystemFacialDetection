<?php

namespace App\Http\Controllers;

use App\Models\UserRegistry;
use App\Models\UsuariosCadastradosModel;
use Illuminate\Http\Request;

class UserRegistryController extends Controller
{
    public function index(){
        $users = UserRegistry::all();
        return view('usersRegistry.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return view('usersRegistry.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Remover caracteres não numéricos do campo cpf_cnpj
        $request->merge([
            'cpf' => preg_replace('/\D/', '', $request->input('cpf'))
        ]);

        $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'string', 'max:11', 'unique:'.UserRegistry::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.UserRegistry::class],
            'phone' => ['required', 'string', 'max:50', 'unique:'.UserRegistry::class],
        ]);

        $user = UserRegistry::create([
            'nome'  => $request->nome,
            'cpf'   => $request->cpf,
            'email' => $request->email,
            'phone' => $request->phone,
            'user_id' => auth()->user()->id
        ]);

        // Retorna os primeiros 30 usuários
        $users = UserRegistry::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->limit(30)->get();

        return redirect(route('user-registry.index', compact('users')));
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        // Onde id > x que vem do post
        // Coletaando todos os usuários da tabela
        return UserRegistry::where('user_id', '>', '0')->get();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
