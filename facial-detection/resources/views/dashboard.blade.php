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

                    <form class="row justify-content-center" method="POST" action="{{ route('user-registry.checkUser') }}">
                        @csrf
                        <div class="row justify-content-center py-3" id="user-image-preview">
                            <svg class="bd-placeholder-img figure-img img-fluid rounded" width="400" height="300" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 400x300" preserveAspectRatio="xMidYMid slice" focusable="false">
                                <title>Placeholder</title>
                                <rect width="100%" height="100%" fill="#868e96"></rect>
                                <text x="50%" y="50%" fill="#dee2e6" dy=".3em">400x300</text>
                            </svg>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col col-6">
                                <input type="submit" value="Reconhecer" class="col col-6 btn btn-warning">
                            </div>
                        </div>

                        {{-- Imagem --}}
                        <input type="hidden" id="imageData" name="imageData">
                    </form>

                    <div class="modal-container mt-4">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" id="btn-capture-facial">
                            Tirar foto para reconhecimento facial
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    {{-- Modal header --}}
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-2" id="staticBackdropLabel">Fazer Reconhecimento Facial...</h1>
                                        <button type="button" class="btn-close fs-3" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    {{-- Modal body --}}
                                    <div class="modal-body">
                                        <!-- Video Element & Canvas -->
                                        <div class="my-4">
                                            <div class="container">
                                                <div class="row justify-content-center">
                                                    <video class="col-12" id="stream" width="640" height="480"></video>
                                                    <canvas class="col-12" id="capture" width="640" height="480"></canvas>
                                                </div>
                                                <div class="row justify-content-center" id="snapshot"></div>
                                            </div>
                                        </div>
                                        <!-- The buttons to control the stream -->
                                        <div class="container my-4">
                                            <div class="row justify-content-center py-4">
                                                <button type="button" id="btn-capture" class="col-4 btn btn-success">Tirar Foto</button>
                                                <button type="button" id="btn-restart" class="col-4 btn btn-warning">Tirar Foto Novamente</button>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Modal footer  --}}
                                    <div class="modal-footer">
                                        <button type="button" id="btn-close" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="button" id="btn-close-enviar" class="btn btn-primary" data-bs-dismiss="modal">Enviar Esta Imagem</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('css')
        <style>
            a {
                text-decoration: none !important;
            }

            #capture {
                display: none;
            }
        </style>
    @endpush

    @push('js')
        <script type="text/javascript">
            var stream = document.getElementById("stream");
            var capture = document.getElementById("capture");
            var snapshot = document.getElementById("snapshot");
            var foto = null;
            var img = null;

            var cameraStream = null;

            function startStreaming() {
                var mediaSupport = 'mediaDevices' in navigator;
                // Reinicia valor da imagem
                foto = null;

                if (mediaSupport && null == cameraStream) {
                    navigator.mediaDevices.getUserMedia({ video: true })
                    .then(function (mediaStream) {
                        cameraStream = mediaStream;
                        stream.srcObject = mediaStream;
                        stream.play();
                    })
                    .catch(function (err) {
                        console.log("Unable to access camera: " + err);
                    });
                } else {
                    alert('Seu navegador não suporta dispositivos de mídia.');
                    return;
                }
            }

            function stopStreaming() {
                if (null != cameraStream) {
                    var track = cameraStream.getTracks()[0];
                    track.stop();
                    stream.load();
                    cameraStream = null;
                }
            }

            function captureSnapshot() {
                if (null != cameraStream) {
                    var ctx = capture.getContext('2d');
                    img = new Image();

                    ctx.drawImage(stream, 0, 0, capture.width, capture.height);
                    img.src = capture.toDataURL("image/png");
                    img.width = 240;

                    snapshot.innerHTML = '';
                    snapshot.appendChild(img);
                    foto = capture.toDataURL("image/png");
                }
            }

            $(document).ready(function() {
                // Esconde o botão de restart ao iniciar
                $("#btn-restart").hide();
                
                // Captura evento de abertura do modal
                $("#btn-capture-facial").on("click", function(event) {
                    // Já começa mostrando o rosto da pessoa
                    startStreaming();

                    // Se o botão de cancelar ou fechar ou enviar aba for pressionado para a gravação
                    $("button[id*='btn-close'], button[class*='btn-close']").on('click', function() {
                        stopStreaming();
                        snapshot.innerHTML = '';
                        $("#btn-capture").show();
                        $("#btn-restart").hide();
                        $("#stream").show();
                    });

                    $("button[id='btn-close-enviar']").on('click', function() {
                        stopStreaming();
                        snapshot.innerHTML = '';
                        $("#btn-capture").show();
                        $("#btn-restart").hide();
                        $("#stream").show();

                        if(foto)
                            $("#imageData").val('data:image/png;base64,' + foto);
                        else
                            $('#imageData').val('');

                        document.querySelector('#user-image-preview').innerHTML = '';

                        if(img)
                            document.querySelector('#user-image-preview').appendChild(img);
                    });

                    // Se o botão de tirar foto for pressionado
                    $("#btn-capture").on('click', function() {
                        // Pega a imagem do vídeo
                        captureSnapshot();
                        // Depois de de capturar para o vídeo
                        stopStreaming();

                        // Mostra o botão de restart
                        $("#btn-capture").hide();
                        $("#btn-restart").show();
                        // Esconde o video
                        $("#stream").hide();
                    });

                    // Lógica reversa
                    $("#btn-restart").on('click', function() {
                        snapshot.innerHTML = '';
                        $("#btn-capture").show();
                        $("#btn-restart").hide();
                        $("#stream").show();
                        startStreaming();
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>
