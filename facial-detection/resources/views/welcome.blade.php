<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Face-All</title>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        {{-- Bootstrap --}}
        <link rel="stylesheet" href="{{ asset('assets/dist/css/bootstrap.min.css') }}">
        {{-- Jquery --}}
        <script src="{{ asset('assets/js/jquery.js') }}"></script>

        <style>
            main {
                height: 75%;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
            <symbol id="cpu-fill" viewBox="0 0 16 16">
                <path d="M6.5 6a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3z"></path>
                <path d="M5.5.5a.5.5 0 0 0-1 0V2A2.5 2.5 0 0 0 2 4.5H.5a.5.5 0 0 0 0 1H2v1H.5a.5.5 0 0 0 0 1H2v1H.5a.5.5 0 0 0 0 1H2v1H.5a.5.5 0 0 0 0 1H2A2.5 2.5 0 0 0 4.5 14v1.5a.5.5 0 0 0 1 0V14h1v1.5a.5.5 0 0 0 1 0V14h1v1.5a.5.5 0 0 0 1 0V14h1v1.5a.5.5 0 0 0 1 0V14a2.5 2.5 0 0 0 2.5-2.5h1.5a.5.5 0 0 0 0-1H14v-1h1.5a.5.5 0 0 0 0-1H14v-1h1.5a.5.5 0 0 0 0-1H14v-1h1.5a.5.5 0 0 0 0-1H14A2.5 2.5 0 0 0 11.5 2V.5a.5.5 0 0 0-1 0V2h-1V.5a.5.5 0 0 0-1 0V2h-1V.5a.5.5 0 0 0-1 0V2h-1V.5zm1 4.5h3A1.5 1.5 0 0 1 11 6.5v3A1.5 1.5 0 0 1 9.5 11h-3A1.5 1.5 0 0 1 5 9.5v-3A1.5 1.5 0 0 1 6.5 5z"></path>
            </symbol>
            <symbol id="tools" viewBox="0 0 16 16">
                <path d="M1 0L0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.356 3.356a1 1 0 0 0 1.414 0l1.586-1.586a1 1 0 0 0 0-1.414l-3.356-3.356a1 1 0 0 0-1.023-.242L10.5 9.5l-.96-.96 2.68-2.643A3.005 3.005 0 0 0 16 3c0-.269-.035-.53-.102-.777l-2.14 2.141L12 4l-.364-1.757L13.777.102a3 3 0 0 0-3.675 3.68L7.462 6.46 4.793 3.793a1 1 0 0 1-.293-.707v-.071a1 1 0 0 0-.419-.814L1 0zm9.646 10.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708zM3 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026L3 11z"></path>
            </symbol>
            <symbol id="toggles2" viewBox="0 0 16 16">
                <path d="M9.465 10H12a2 2 0 1 1 0 4H9.465c.34-.588.535-1.271.535-2 0-.729-.195-1.412-.535-2z"></path>
                <path d="M6 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 1a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm.535-10a3.975 3.975 0 0 1-.409-1H4a1 1 0 0 1 0-2h2.126c.091-.355.23-.69.41-1H4a2 2 0 1 0 0 4h2.535z"></path>
                <path d="M14 4a4 4 0 1 1-8 0 4 4 0 0 1 8 0z"></path>
            </symbol>
        </svg>


        {{-- Header --}}
        <header class="container">
            <div class="d-flex flex-wrap justify-content-center py-3 mb-4 align-items-center">
                <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                    <img src="{{ asset('assets/imgs/logo_1.png') }}" alt="Logo Face-All" width="150" />
                </a>

                <ul class="nav nav-pills">
                    <li class="nav-item"><a href="#" class="nav-link"><x-span-text :value="__('About')"/></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><x-span-text :value="__('Contact')"/></a></li>
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item"><a href="{{ url('/dashboard') }}" class="nav-link"><x-span-text :value="__('Dashboard')"/></a></li>
                        @else
                            <li class="nav-item"><a href="{{ route('login') }}" class="nav-link"><x-span-text :value="__('Log in')"/></a></li>

                            @if (Route::has('register'))
                                <li class="nav-item"><a href="{{ route('register') }}" class="nav-link"><x-span-text :value="__('Register')"/></a></li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </header>

        {{-- Main --}}
        <main>

            <div class="container px-4 py-4" id="hanging-icons">
                <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
                    <div class="col d-flex align-items-start">
                    <div class="icon-square text-body-emphasis bg-body-secondary d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                        <svg class="bi" width="1em" height="1em"><use xlink:href="#toggles2"></use></svg>
                    </div>
                    <div>
                        <h3 class="fs-2 text-body-emphasis">Detecção</h3>
                        <p>Detecção Facial de Alto Nível. Segurança e Tecnologia em Harmonia.</p>
                    </div>
                    </div>
                    <div class="col d-flex align-items-start">
                    <div class="icon-square text-body-emphasis bg-body-secondary d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                        <svg class="bi" width="1em" height="1em"><use xlink:href="#cpu-fill"></use></svg>
                    </div>
                    <div>
                        <h3 class="fs-2 text-body-emphasis">Segurança</h3>
                        <p>Segurança Inovadora, Reconhecimento Preciso. Descubra a nova era da detecção facial.</p>
                    </div>
                    </div>
                    <div class="col d-flex align-items-start">
                    <div class="icon-square text-body-emphasis bg-body-secondary d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                        <svg class="bi" width="1em" height="1em"><use xlink:href="#tools"></use></svg>
                    </div>
                    <div>
                        <h3 class="fs-2 text-body-emphasis">Parceria</h3>
                        <p>Seu Parceiro em Identificação Avançada. Proteja, Inove, Reconheça.</p>
                    </div>
                    </div>
                </div>
            </div>

            <div class="px-4 pt-5 my-5 text-center">
                <h1 class="d-flex justify-content-center">
                    <a href="/">
                        <img src="{{ asset('assets/imgs/logo_1.png') }}" alt="Logo Face-All" width="200" />
                    </a>
                </h1>
                <div class="col-lg-6 mx-auto">
                    <p class="lead mb-4">Nossa tecnologia de detecção facial oferece soluções avançadas e seguras para proteger sua empresa e seus entes queridos. Com precisão inigualável e respeito à privacidade, identificamos indivíduos em segundos, simplificando a segurança. Adequada para ambientes corporativos, governamentais e públicos, nossa solução garante acesso seguro e monitoramento eficaz. Escolha nossa empresa e experimente inovação, conveniência e proteção superior. Transforme a segurança com nossa tecnologia de reconhecimento facial de ponta.</p>
                </div>
            </div>

        </main>

        {{-- Footer --}}
        <footer class="py-3 my-4">
            <ul class="nav justify-content-center border-top pb-3 mb-3">
            <li class="nav-item"><a href="/" class="nav-link px-2 text-body-secondary">Home</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary"><x-span-text :value="__('About')"/></a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary"><x-span-text :value="__('Contact')"/></a></li>
            </ul>
            <p class="text-center text-body-secondary">© 2024 Face-All, Inc</p>
        </footer>
        
        {{-- Bootsrap --}}
        <script src="{{ asset('/assets/dist/js/bootstrap.bundle.min.js') }}"></script>
    </body>
</html>
