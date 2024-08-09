<?php

namespace App\Http\Controllers;

use App\Models\UserRegistry;
use App\Models\UsuariosCadastradosModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        // Retorna a view para criar um novo usuário
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
        // return UserRegistry::where('user_id', '>', '0')->get();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $user = UserRegistry::find($id);
        return view('usersRegistry.edit', compact('user'));
    }


    public function delete(Request $request, $id)
    {
        $user = UserRegistry::find($id);
        return view('usersRegistry.delete', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // Tratamento de dados da requisição
        $request->merge([
            'cpf' => preg_replace('/\D/', '', $request->input('cpf'))
        ]);

        // Validando os dados da requisição
        $validator = Validator::make($request->all(), [
            'nome' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'string', 'max:11', 'unique:'.UserRegistry::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.UserRegistry::class],
            'phone' => ['required', 'string', 'max:50', 'unique:'.UserRegistry::class],
        ]);

        // Encontre o item pelo ID
        $user = UserRegistry::find($request->post('id'));

        // Atualizando os dados do usuário
        $user->update($request->all());

        // Retorna os primeiros 30 usuários
        $users = UserRegistry::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->limit(30)->get();

        return redirect()->route('user-registry.index', compact('users'))->with('message', 'Usuário atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $user = UserRegistry::find($request->post('_id'));
        if(isset($request->all()['_cpf']) && $user->cpf == $request->all()['_cpf']) {
            $user->delete();
        }

        // Retorna os primeiros 30 usuários
        $users = UserRegistry::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->limit(30)->get();

        return redirect()->route('user-registry.index', compact('users'))->with('delete', 'Usuário deletado com sucesso!');
    }


    public function checkFaceUserRegistry(Request $request) {
        $url = "http://python-facial-detection:8000/reconizer";

        // Valida se a imagem foi enviada
        request()->validate([
            'imageData' => ['required'],
        ]);
        
        // Salva a imagem em base64 no volume docker
            $nomeImagem    = time() . 'userform' . '.png';
            $caminhoImagem = config('app.path_cache_photos') . '/' .auth()->user()->id . '/';
            $imageData     = $request->input('imageData');
            // Salva a imagem no volume compartilhado
            $this->salvarImagem($imageData, $caminhoImagem, $nomeImagem);


        // Dados do formulário para o python
        $postData = [
            'caminho_da_imagem_cache' => '/app/fotos/cache/'.auth()->user()->id . '/' . $nomeImagem,
            'pasta_fotos_user'        => '/app/fotos/cache/'.auth()->user()->id . '/'  // Tirar a pasta de cache e colocar a pasta principal
        ];

            // Inicializar cURL
            $ch = curl_init();

            // Configurar opções do cURL
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));


            // Executar a requisição cURL e obter a resposta
            $response = curl_exec($ch);

            // Verificar se houve erros na requisição
            if (curl_errno($ch)) {
                echo 'Erro no cURL: ' . curl_error($ch);
                curl_close($ch);
                die();
            }

            // Fechar a sessão cURL
            curl_close($ch);

        // Decodificar o JSON da resposta
        $data = json_decode($response, true);
        dd($data);

        // Se conseguiu identificar o rosto
        // Se não conseguiu identificar o rosto


            // // Verificar se a decodificação foi bem-sucedida
            // if ($data === NULL) {
            //     die('Erro ao decodificar JSON');
            // }

        // Fazer algo com os dados decodificados
    }

    private function salvarImagem($base64String, $caminhoImagem, $nomeImagem){
        // Remover o prefixo "data:image/png;base64," da string base64
        $base64String = preg_replace('#^data:image/\w+;base64,#i', '', $base64String);
        
        // Decodificar a string base64
        $imageData = base64_decode($base64String);
        
        // Verifique se a string foi decodificada corretamente
        if ($imageData === false) {
            die('Erro ao decodificar a string base64');
        }

        // Verifique se o diretório existe e crie se necessário
        if (!is_dir($caminhoImagem)) {
            if (!mkdir($caminhoImagem, 0777, true)) {
                die('Falha ao criar diretório');
            }
        }
        // dd($caminhoImagem);

        // Salve a imagem como um arquivo PNG no volume Docker
        if (file_put_contents($caminhoImagem.$nomeImagem, $imageData)) {
            echo "Imagem salva com sucesso em $caminhoImagem.$nomeImagem";
        } else {
            echo "Erro ao salvar a imagem";
        }
        // dd($caminhoImagem, $nomeImagem);

    }
}
