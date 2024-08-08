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

                    <form action="{{ route('user-registry.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col col-12">
                                <h3 class="text-center">Formulário de cadastro de usuário</h3>
                            </div>

                            <div class="col col-12">
                                <!-- Name -->
                                <div class="mt-4">
                                    <x-input-label for="nome" :value="__('Name')" />
                                    <x-text-input id="nome" class="block mt-2 w-full" type="text" name="nome" value="{{ old('nome') }}" required autofocus autocomplete="nome" />
                                    <x-input-error :messages="$errors->get('nome')" class="mt-2" />
                                </div>
                            </div>

                            <div class="col col-12 mt-4">
                                <!-- CPF -->
                                <div x-data>
                                    <x-input-label for="cpf" :value="__('CPF')" />
                                    <x-text-input id="cpf" class="block mt-2 w-full" type="text" name="cpf" value="{{ old('cpf') }}"  x-mask="999.999.999-99" placeholder="999.999.999-99" required  autocomplete="cpf" />    
                                    <x-input-error :messages="$errors->get('cpf')" class="mt-2"/>
                                </div>
                            </div>
                            
                            <div class="col col-12 mt-4">
                                <!-- Email Address -->
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-2 w-full" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div class="col col-12 mt-4">
                                <!-- Phone -->
                                <x-input-label for="phone" :value="__('Phone')" />
                                <x-text-input id="phone" class="block mt-2 w-full" type="text" name="phone" value="{{ old('phone') }}"  autocomplete="phone" />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>

                            <div class="col col-12 mt-4">
                                <!-- Photo -->
                                <x-input-label for="photo" :value="__('Photo')" />
                                <x-text-input id="photo" class="block mt-2 w-full" type="file" name="photo" value="{{ old('photo') }}"  autocomplete="photo" />
                                <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                            </div>

                            <div class="col col-6 mt-5">
                                <x-primary-button>
                                    {{ __('Save') }}
                                </x-primary-button>
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
