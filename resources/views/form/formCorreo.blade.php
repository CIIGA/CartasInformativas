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
                <form action="{{ route('subirdatos') }}" method="POST" enctype="multipart/form-data"
                    id="formSubirDatos">
                    @csrf
                    <div class="mb-3">
                        <label for="archivo" class="form-label">Selecciona un archivo:</label>
                        <input type="file" class="form-control
                        @error('fileExcel')
                        border border-danger rounded-2
                        @enderror" id="fileExcel" name="fileExcel">
                        <div class="bg-danger text-white text-center">
                            <p>Solo formatos .Xlsx</p>
                        </div>
                        @error('fileExcel')
                        <div class="text-danger text-center">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-save" id="btnSubirDatos">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>