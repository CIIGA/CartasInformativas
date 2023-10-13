<div class="m-4 d-flex gap-4">
    <div>
        <button class="btn btn-save" data-bs-toggle="modal" data-bs-target="#datosModal">Subir datos</button>
    </div>
    <div class="mb-3">
        <label for="fechaHistorico" class="form-label">Selecciona una fecha:</label>
        <select class="form-select" id="fechaHistorico">
            <option value="">Selecciona una fecha</option>
            @foreach ($historico as $row)
                <option value="{{ $row->fecha_enviado }}">{{ $row->fecha_enviado }}</option>
            @endforeach
        </select>
        <!-- Campo oculto para enviar el valor del combobox seleccionado -->
        <input type="hidden" id="idPlazaCorreo" name="idPlazaCorreo" value="">
    </div>
    <div>
        <button class="btn btn-save" id="verPDF">Reporte</button>
    </div>
</div>
<!-- Agrega un contenedor para la tabla y la paginación -->
<div id="tablaContenedor">
    <div id="tablaHistorico"></div>
</div>

<!-- Modal para cargar la datos-->
<div class="modal fade" id="datosModal" tabindex="-1" aria-labelledby="datosModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fs-5" id="datosModal">Subir datos</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- <form id="formSubirDatos" action="{{ route('subirdatos') }}" method="POST" enctype="multipart/form-data" > --}}
                <form id="formSubirDatos" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="archivo" class="form-label">Selecciona un archivo que contenga estos
                            encabezados:</label>
                        <table class="table table-success">
                            <thead>
                                <tr>
                                    <td scope="col">Cuenta</td>
                                    <td scope="col">Fecha_Leido</td>
                                    <td scope="col">Fecha_enviado</td>
                                </tr>
                            </thead>
                        </table>

                        <input type="hidden" name="idPlaza" value="{{ $idPlaza }}">
                        <input type="file"
                            class="form-control
                        @error('fileExcel')
                        border border-danger rounded-2
                        @enderror"
                            id="fileExcel" name="fileExcel"  accept=".xlsx">
                        <div class="bg-danger text-white text-center">
                            <p>Solo formatos .xlsx</p>
                        </div>
                        @error('fileExcel')
                            <div class="text-danger text-center">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-save" id="btnSubirDatos">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
<script>
    $(document).ready(function() {
        $('#formSubirDatos').submit(function(e) {
            e.preventDefault(); // Evita la recarga de la página
            $("#datosModal").modal("hide");
            Swal.fire({
                title: "Importando Datos",
                html: "Por favor, espere...",
                icon: "info",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                },
            });
            var formData = new FormData(this);

            $.ajax({
                url: '/subirdatos',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.close();
                    if (response.success == 'encabezados') {
                        Swal.fire({
                            title: "Error!",
                            text: "Los encabezados no son los correctos",
                            icon: "error",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                            
                        });
                    } else if (response.success == 'SinArchivo') {
                        Swal.fire({
                            title: "Error!",
                            text: "No se encontro ningun archivo",
                            icon: "error",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                            
                        });
                    } else if (response.success == 'SinDatos') {
                        Swal.fire({
                            title: "Error!",
                            text: "Este archivo no tiene Datos que leer",
                            icon: "error",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                            
                        });
                    } else if (response.success == 'exito') {
                        Swal.fire({
                            title: "Exito!",
                            text: "Datos Cargados Correctamente",
                            icon: "success",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                            
                        });
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: "Error de petición",
                            icon: "error",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                            
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: "Error!",
                        text: "Error de procesamiento",
                        icon: "error",
                        showConfirmButton: true,
                        allowOutsideClick: false,
                        
                    });
                }
            });
        });
    });
</script>



<script>
    // Variable para almacenar la página actual
    var paginaActual = 1;

    // Función para construir la tabla con los datos recibidos
    function construirTabla(data) {
        var tablaHtml = '<table class="table">';
        tablaHtml += '<thead><tr><th>Cuenta</th><th>Fecha Enviado</th><th>Fecha Leido</th></tr></thead>';
        $.each(data.data, function(index, row) {
            tablaHtml += '<tr>';
            tablaHtml += '<td>' + row.cuenta + '</td>';
            tablaHtml += '<td>' + row.fecha_enviado + '</td>';
            tablaHtml += '<td>' + row.fecha_leido + '</td>';
            tablaHtml += '</tr>';
        });
        tablaHtml += '</table>';

        // Mostrar la tabla en el div 'tablaHistorico'
        $('#tablaHistorico').html(tablaHtml);
    }

    // Función para manejar la paginación de la tabla
    function manejarPaginacion(data) {
        var pagination = '<ul class="pagination">';
        if (data.prev_page_url) {
            pagination += '<li class="page-item"><a class="page-link" href="#" onclick="cargarPagina(' + (paginaActual -
                1) + ')">Anterior</a></li>';
        }
        if (data.next_page_url) {
            pagination += '<li class="page-item"><a class="page-link" href="#" onclick="cargarPagina(' + (paginaActual +
                1) + ')">Siguiente</a></li>';
        }
        pagination += '</ul>';

        // Mostrar la paginación debajo de la tabla
        $('#tablaContenedor').append(pagination);
    }

    // Función para cargar una página específica mediante AJAX y actualizar la tabla y la paginación
    function cargarPagina(pagina) {

        $.ajax({
            url: "{{ route('obtenerDatosTabla') }}",
            method: 'GET',
            data: {
                fecha: $('#fechaHistorico').val(),
                page: pagina
            },
            success: function(response) {
                paginaActual = pagina;
                construirTabla(response);
                // Eliminar la paginación anterior antes de cargar una nueva
                $('#tablaContenedor .pagination').remove();
                manejarPaginacion(response);
            },
            error: function() {
                mostrarAlerta('error', 'Error al obtener los datos.');
            }
        });
    }

    $(document).ready(function() {

        $('#fechaHistorico').on('change', function() {
            cargarPagina(1);
        });
    });
</script>
<script>
    // Suponiendo que tienes un botón o elemento en tu HTML con el id "verPDF" 
    document.getElementById('verPDF').addEventListener('click', function() {
        // Aquí colocamos la lógica para abrir una nueva ventana o pestaña del navegador
        // y cargar la URL que generará el PDF
        var plazaId = document.getElementById('combobox').value; // Asegúrate de tener la id correcta
        var selectedDate = document.getElementById('fechaHistorico').value; // Asegúrate de tener el id correcto

        if (selectedDate && plazaId) {
            selectedDate = selectedDate.replace(/\//g, '-');
            // Construir la URL con ambos parámetros
            var pdfUrl = "{{ route('pdfCorreo', ['idPlaza' => ':idPlaza', 'fecha' => ':fecha']) }}"
                .replace(':idPlaza', encodeURIComponent(plazaId))
                .replace(':fecha', encodeURIComponent(selectedDate));
            window.open(pdfUrl, '_blank');
        } else {

            Swal.fire({
                title: "Error!",
                text: "Primero seleccione una fecha",
                icon: "error",
                showConfirmButton: false,
                allowOutsideClick: false,
                timer: 1000,
            });
        }
    });
</script>
