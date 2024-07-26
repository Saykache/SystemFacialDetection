<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="container text-center max-w-x">
                    <form action="" method="POST">
                        <div class="row justify-content-between align-items-center">
                            <div class="col col-4">
                                &nbsp;
                            </div>
                            {{-- Actions User Registry --}}
                            <x-actions-user-registry/>
                        </div>
                    </form>
                </div>

                <br>

                <div class="max-w-x">
                    <h3>Lista de Usuários Cadastrados</h3>
                    <br>
                </div>

                @if( session()->has('message'))
                    <br>
                        <h3 class="text-start bg-secondary-subtle">{{ session('message') }}</h3>
                    <br>
                @endif

                <table id="users-list" class="table table-borderless table-hover table-bordered  table-striped max-w-x">
                    <thead class="">
                        <tr>
                        <th style="width: 40%;" colspan="2">{{ __('Name') }}</th>
                        <th style="width: 30%;">{{ __('Phone') }}</th>
                        <th style="width: 30%;">{{ __('E-Mail Address') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($users))
                            @forelse ($users as $item)
                                <tr>
                                    <td><input type="radio" value="{{ $item['id'] }}" name="radio-user"></td>
                                    <td>{{ $item['nome'] }}</td>
                                    <td>{{ $item['phone'] }}</td>
                                    <td>{{ $item['email'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">{{ __('No registered users') }}</td>
                                </tr>
                            @endforelse
                        @else 
                            <tr>
                                <td colspan="4">Liste Usuários</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
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

    @push('js')
        <script type="text/javascript">
            let lineSelected = "#";

            $('#users-list tbody tr').on('click', function(event) {
                // Evita que o clique no radio dispare novamente o evento na linha
                if (event.target.type !== 'radio') {
                    // Pega o radio na linha
                    let radio = $(this).find('input[type="radio"]');
                    // Seleciona o radio
                    radio.prop('checked', true);
                    // Verifica se o radio selecionado é diferente de vazio
                    lineSelected = radio.prop('checked') ? radio.val() : "#";

                    // Mudando action
                    if (lineSelected !== "#") {

                        // Habilitar botão de deletar e editar
                        $("#btn-edit").prop('disabled', false);
                        $("#btn-delete").prop('disabled', false);

                        // Seta o valor dos inputs
                        $("#input-edit").val(lineSelected);
                        $("#input-delete").val(lineSelected);

                        // Setando actions dos buttons
                        $("#btn-delete").prop('href', "{{ config('app.url') . '/user-registry/' }}" + lineSelected + "/delete");
                        $("#btn-edit").prop('href', "{{ config('app.url') . '/user-registry/' }}" + lineSelected  + "/edit");

                    } else {

                        // Desabilitar botão de deletar e editar
                        $("#btn-edit").prop('disabled', true);
                        $("#btn-delete").prop('disabled', true);

                        // Seta o valor dos inputs para vazio
                        $("#input-edit").val('');
                        $("#input-delete").val('');
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>
