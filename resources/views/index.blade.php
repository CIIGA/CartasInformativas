@extends('layout.index')
@section('titulo')
Inicio
@endsection
@section('css')
<style>
    /* Estilos para el contenedor de la tabla */
    #tablaContenedor {
        max-height: 600px;
        /* Altura máxima del contenedor */
        overflow-y: auto;
        /* Habilitar el scroll vertical */
    }

    /* Estilos para la tabla */
    .table {
        width: 100%;
        table-layout: fixed;
        /* Fijar el ancho de las columnas */
    }

    .table thead th {
        position: sticky;
        /* Fijar el encabezado */
        top: 0;
        background-color: #f2f2f2;
        z-index: 1;
        /* Asegurar que el encabezado quede por encima del scroll */
    }
</style>
@endsection
@section('contenido')

<div class="container-fluid">

    <div class="col-md-6 mx-auto">
        <div class="mb-3">
            <label for="combobox" class="form-label">Selecciona una plaza:</label>
            <select class="form-select" id="combobox">
                <option value="">Selecciona una opción</option>
                @foreach ($plazas as $plaza)
                <option value="{{ $plaza->id }}">{{ $plaza->plaza }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row" id="content">
        <div class="col-md-8">
            <!-- Listas -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info"
                        type="button" role="tab" aria-controls="info" aria-selected="true">
                        Pregrabadas
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="domicilio-tab" data-bs-toggle="tab" data-bs-target="#domicilio"
                        type="button" role="tab" aria-controls="domicilio" aria-selected="false">
                        <i class="fa-solid fa-house"></i>
                        Contact Center
                    </button>
                </li>
                <li class="nav-item" role="presentation" id="correos">
                    <button class="nav-link" id="contacto-tab" data-bs-toggle="tab" data-bs-target="#contacto"
                        type="button" role="tab" aria-controls="contacto" aria-selected="false">
                        <i class="fa-solid fa-address-book"></i>
                        Campaña de correos
                    </button>
                </li>
            </ul>
            <!--  Contenidos -->
            <div class="tab-content">
                <div class="tab-pane active" id="info" role="tabpanel" aria-labelledby="info-tab">
                    @include('form.formPregreabadas')
                </div>
                <div class="tab-pane" id="domicilio" role="tabpanel" aria-labelledby="domicilio-tab">
                    @include('form.formContactCenter')
                </div>
                <div class="tab-pane" id="contacto" role="tabpanel" aria-labelledby="contacto-tab">
                    <div id="correos-content"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div>
                <!-- Tarjeta para mostrar la imagen y la información de la plaza -->
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="" alt="Imagen plaza" id="imagenPlaza">
                    <div class="card-body">
                        <p class="card-text">Imagen de la plaza</p>
                        <!-- Botón para abrir el modal -->
                        <button type="button" class="btn btn-save" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">Cambiar Imagen</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal para cambiar la imagen-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fs-5" id="exampleModalLabel">Actualizar Imagen</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" id="formSubirArchivos">
                {{-- <form action="{{ route('guardar_archivos') }}" method="POST" enctype="multipart/form-data" id="formSubirArchivos"> --}}
                    @csrf
                    <!-- Campo oculto para enviar el valor del combobox seleccionado -->
                    <input type="hidden" id="plazaId" name="plaza_id" value="">

                    <!-- Campo de archivo de Bootstrap 5 -->
                    <div class="mb-3">
                        <label for="archivo" class="form-label">Selecciona un archivo:</label>
                        <input type="file" class="form-control" id="archivo" name="archivo" accept=".jpg">
                        <div class="bg-danger text-white text-center">
                            <p>Solo formatos .jpg</p>
                        </div>
                    </div>
                    <button type="button" class="btn btn-save" id="btnSubirArchivos">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')




<script src="{{ asset('js/mostrarContenido.js') }}"></script>
<script src="{{ asset('js/formContact.js') }}"></script>
<script src="{{ asset('js/formPregrabadas.js') }}"></script>
<script src="{{ asset('js/ShowImage.js') }}"></script>
<script src="{{ asset('js/SweetAlert.js') }}"></script>
<script src="{{ asset('js/StoreImage.js') }}"></script>
<script src="{{ asset('js/correos.js') }}"></script>
@if(Session::has('error'))
<script>
    mostrarAlerta('error', "{{ Session::get('error') }}");
</script>
@endif
@if(Session::has('success'))
<script>
    mostrarAlerta('success', "{{ Session::get('success') }}");
</script>
@endif
@endsection