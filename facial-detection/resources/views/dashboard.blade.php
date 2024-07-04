<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
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
                                <div class="col col-6">
                                    <div class="row">
                                        <div class="btn-group" role="group" aria-label="Grid Actions List Users System">
                                            <a class="btn btn-outline-danger"  href="{{ "#" }}" role="button">Excluir</a>
                                            <a class="btn btn-outline-success" href="{{ "#" }}" role="button">Adicionar</a>
                                            <a class="btn btn-outline-primary" href="{{ "#" }}" role="button">Listar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <br>

                    <div class="max-w-x">
                        <h3>Lista de Usuários Cadastrados</h3>
                        <br>
                    </div>

                    <table id="users-list" class="table table-borderless table-hover table-bordered  table-striped max-w-x">
                        <thead class="">
                            <tr>
                            <th style="width: 40%;" colspan="2">Name</th>
                            <th style="width: 30%;">cpf</th>
                            <th style="width: 30%;">email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="655">
                                <td><input type="checkbox"></td>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr id="215">
                                <td><input type="checkbox"></td>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                            <tr id="456">
                                <td><input type="checkbox"></td>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
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
            $('#users-list tbody tr').on('click', function(event){
                // Evita que o clique no checkbox dispare novamente o evento na linha
                if (event.target.type !== 'checkbox') {
                    var checkbox = $(this).find('input[type="checkbox"]');
                    checkbox.prop('checked', !checkbox.prop('checked'));

                    // console.log($(this).prop('id'));
                }
            });


            
        </script>
    @endpush
</x-app-layout>
