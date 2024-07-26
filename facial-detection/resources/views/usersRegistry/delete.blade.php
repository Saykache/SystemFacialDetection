<x-form>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="row justify-content-center my-5">
                <div class="col col-4">
                    <a href="{{ route('user-registry.index') }}">
                        <x-application-logo/>
                    </a>
                </div>
            </div>
            
            <div class="p-4 g-white shadow sm:rounded-lg">
                <form action="{{ route('user-registry.destroy') }}" method="POST" class="text-center">
                    @csrf
                    @method('DELETE')
                    <input type="text" name="_id" hidden value="{{ $user->id }}">
                    <input type="hidden" name="_cpf" value="{{ $user->cpf }}">
                    <h1>Formulário de Delete</h1>

                    <div class="mb-3 fs-5">
                        <br>
                        <p>
                            Você tem certeza que deseja excluir este usuário: <br>
                            <span class="text-danger">{{ $user->nome }}</span>?
                        </p>

                        <div class="row justify-content-between">
                            <div class="col-6">
                                <a class="btn btn-primary" href="{{ route('user-registry.index') }}">Cancelar</a>
                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-danger">Excluir</button>    
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('css')
        <style>
            a {
                text-decoration: none !important;
            }
        </style>
    @endpush
</x-form>
