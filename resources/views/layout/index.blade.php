<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cartas - @yield('titulo')</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('img/icons/implementtaIcon.png') }}">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-material-ui/material-ui.css"
        id="theme-styles">
    @yield('css')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <a href="{{ asset('../../../../Administrador/selectSistem.php') }}"><img
                src="{{ asset('img/icons/logoImplementtaHorizontal.png') }}" width="250" height="82" alt=""></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto gap-2">
                <a class="nav-item nav-link" href="{{route('index')}}"> Inicio
                </a>
                <a class="nav-item nav-link"
                    href="https://gallant-driscoll.198-71-62-113.plesk.page/implementta/modulos/Administrador/logout.php">
                    Salir <i class="fa-solid fa-right-from-bracket"></i></a>
            </ul>
        </div>
    </nav>
    <div class="main">
        @yield('contenido')
    </div>
    {{-- Footer --}}
    <footer class="navbar nav-pills nav-fill navbar-expand-lg gap-5 px-5 footer-fixed">
        <span class="navbar-text" style="font-size:12px;font-weigth:normal;color: #7a7a7a;width: 40%;">
            Implementta ©<br>
            Estrategas de México <i class="far fa-registered"></i><br>
            Centro de Inteligencia Informática y Geografía Aplicada CIIGA
            <hr style="width:105%;border-color:#7a7a7a;">
            Created and designed by <i class="far fa-copyright"></i>
            <?php echo date('Y'); ?> Estrategas de México<br>
        </span>
        <span class="navbar-text mx-lg-5" style="font-size:12px;font-weigth:normal;color: #7a7a7a;">
            Contacto:<br>
            <i class="fas fa-phone-alt"></i> Red: 187<br>
            <i class="fas fa-phone-alt"></i> 66 4120 1451<br>
            <i class="fas fa-envelope"></i> sistemas@estrategas.mx<br>
        </span>
        <form class="form-inline my-2 my-lg-0 gap-2 ">
            <a href="../../index.php"><img src="{{ asset('img/bg/logoImplementta.png') }}" width="155" height="150"
                    alt=""></a>
            <a href="http://estrategas.mx/" target="_blank"><img src="{{ asset('img/icons/logoTop.png') }}" width="200"
                    height="85" alt=""></a>
        </form>
    </footer>
    <!-- Script para configurar Dropzone -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"
        integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    @yield('js')
</body>

</html>