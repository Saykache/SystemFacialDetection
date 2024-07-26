<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        
        <!-- Tipo Pessoa -->
        <div class="mt-4" x-data>
            <x-input-label for="tipo_pessoa" :value="__('Tipo de Pessoa')" />

            <select id="tipo_pessoa" name="tipo_pessoa" class="form-select block mt-1 w-full mt-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="F" selected>Física</option>
                <option value="J">Jurídica</option>
            </select>

            <x-input-error :messages="$errors->get('tipo_pessoa')" class="mt-2"/>
        </div>

        <!-- CPF / CNPJ -->
        <div class="mt-4" x-data>
            <x-input-label for="cpf_cnpj" :value="__('CPF / CNPJ')" />

            <x-text-input id="cpf_cnpj" class="block mt-1 w-full mt-2" type="text" name="cpf_cnpj"  x-mask="999.999.999-99" placeholder="999.999.999-99" required  autocomplete="new-cpf_cnpj" />

            <x-input-error :messages="$errors->get('cpf_cnpj')" class="mt-2"/>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
    @push('js')
        <script>
            let tipoPessoa = $("#tipo_pessoa").val();

            $("#tipo_pessoa").change(function(){
                tipoPessoa = $("#tipo_pessoa").val();

                if(tipoPessoa == 'F'){
                    $("#cpf_cnpj").attr("x-mask", "999.999.999-99");
                    $("#cpf_cnpj").attr("placeholder", "999.999.999-99");

                }else if(tipoPessoa == 'J'){
                    $("#cpf_cnpj").attr("x-mask", "99.999.999/9999-99");
                    $("#cpf_cnpj").attr("placeholder", "99.999.999/9999-99");
                }
            });
        </script>
    @endpush
    @push('css')
        <style>
            a {
                text-decoration: none !important;
            }
        </style>
    @endpush
</x-guest-layout>
